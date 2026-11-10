<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // LOGIKA HAK AKSES DATA
        if ($user->role == 'admin') {
            // Admin biasa cuma liat produk cabangnya sendiri
            $produks = Produk::where('id_cabang', $user->id_cabang)->latest()->get();
        } else {
            // Owner & Super Admin liat semua
            $produks = Produk::latest()->get();
        }

        $kategoris = Kategori::all();
        $cabangs = Cabang::all();

        return view('admin.produk.index', compact('produks', 'kategoris', 'cabangs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi Input
        $validated = $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama' => 'required',
            'id_kategori' => 'required|exists:kategoris,id',
            'id_cabang' => 'required|exists:cabangs,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
        ], [
            'foto.max' => 'Ukuran foto terlalu besar. Maksimal 2 MB.',
            'foto.mimes' => 'Foto harus berformat PNG atau JPG.',
        ]);

        // Admin biasa hanya boleh menambah produk untuk cabangnya sendiri.
        if ($user->role === 'admin') {
            $validated['id_cabang'] = $user->id_cabang;
        }

        // Upload Foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('produk-images', config('filesystems.upload_disk'));
        }

        Produk::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $user = Auth::user();

        // Admin biasa tidak boleh mengubah produk cabang lain.
        if ($user->role === 'admin' && $produk->id_cabang != $user->id_cabang) {
            abort(403, 'Anda tidak memiliki akses ke produk cabang lain.');
        }

        $validated = $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk,'.$produk->id,
            'nama' => 'required',
            'id_kategori' => 'required|exists:kategoris,id',
            'id_cabang' => 'required|exists:cabangs,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'foto.max' => 'Ukuran foto terlalu besar. Maksimal 2 MB.',
            'foto.mimes' => 'Foto harus berformat PNG atau JPG.',
        ]);

        // Admin biasa hanya boleh menyimpan produk di cabangnya sendiri.
        if ($user->role === 'admin') {
            $validated['id_cabang'] = $user->id_cabang;
        }

        // Cek Ganti Foto
        if ($request->hasFile('foto')) {
            $disk = config('filesystems.upload_disk');
            // Hapus foto lama jika ada
            if ($produk->foto) {
                Storage::disk($disk)->delete($produk->foto);
            }
            $validated['foto'] = $request->file('foto')->store('produk-images', $disk);
        }

        $produk->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $user = Auth::user();

        // Admin biasa tidak boleh menghapus produk cabang lain.
        if ($user->role === 'admin' && $produk->id_cabang != $user->id_cabang) {
            abort(403, 'Anda tidak memiliki akses ke produk cabang lain.');
        }

        $disk = config('filesystems.upload_disk');

        // Hapus semua foto gallery produk dari penyimpanan sebelum record-nya
        // ikut terhapus lewat cascade foreign key.
        foreach ($produk->gallery as $gallery) {
            if ($gallery->foto) {
                Storage::disk($disk)->delete($gallery->foto);
            }
        }

        // Hapus foto utama dari penyimpanan
        if ($produk->foto) {
            Storage::disk($disk)->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}