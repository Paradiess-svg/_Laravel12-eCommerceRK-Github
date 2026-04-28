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
        // Validasi Input
        $validated = $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama' => 'required',
            'id_kategori' => 'required',
            'id_cabang' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|file|max:2048', // Max 2MB
        ], [
            'foto.max' => 'Ukuran foto terlalu besar. Maksimal 2 MB.'
        ]);

        // Upload Foto
        if ($request->file('foto')) {
            $validated['foto'] = $request->file('foto')->store('produk-images');
        }

        Produk::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $rules = [
            'nama' => 'required',
            'id_kategori' => 'required',
            'id_cabang' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|file|max:2048',
        ];

        // Cek unik kode produk (kecuali punya diri sendiri)
        if($request->kode_produk != $produk->kode_produk){
            $rules['kode_produk'] = 'required|unique:produks';
        }

        $validated = $request->validate($rules, [
            'foto.max' => 'Ukuran foto terlalu besar. Maksimal 2 MB.'
        ]);

        // Cek Ganti Foto
        if ($request->file('foto')) {
            // Hapus foto lama jika ada
            if ($produk->foto) {
                Storage::delete($produk->foto);
            }
            $validated['foto'] = $request->file('foto')->store('produk-images');
        }

        $produk->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Hapus foto dari penyimpanan
        if ($produk->foto) {
            Storage::delete($produk->foto);
        }

        $produk->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}