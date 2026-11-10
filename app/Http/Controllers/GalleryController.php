<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('produk')->latest()->get();
        $produks = Produk::all();
        return view('admin.gallery.index', compact('galleries', 'produks'));
    }

    public function store(Request $request)
    {
        $disk = config('filesystems.upload_disk');

        $validated = $request->validate([
            'id_produk' => 'required|exists:produks,id',
            'deskripsi' => 'nullable', // <--- GANTI JADI deskripsi
            'foto'      => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'required' => ':attribute wajib diisi.',
            'image'    => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto terlalu besar. Maksimal 2 MB.',
            'foto.mimes' => 'Foto harus berformat PNG atau JPG.'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('gallery-images', $disk);
        }

        Gallery::create($validated);

        return redirect()->back()->with('success', 'Foto gallery berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $disk = config('filesystems.upload_disk');

        $validated = $request->validate([
            'id_produk' => 'required|exists:produks,id',
            'deskripsi' => 'nullable', // <--- GANTI JADI deskripsi
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'foto.max' => 'Ukuran foto terlalu besar. Maksimal 2 MB.',
            'foto.mimes' => 'Foto harus berformat PNG atau JPG.'
        ]);

        if ($request->hasFile('foto')) {
            if ($gallery->foto) Storage::disk($disk)->delete($gallery->foto);
            $validated['foto'] = $request->file('foto')->store('gallery-images', $disk);
        }

        $gallery->update($validated);

        return redirect()->back()->with('success', 'Gallery berhasil diupdate!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->foto) Storage::disk(config('filesystems.upload_disk'))->delete($gallery->foto);
        $gallery->delete();
        return redirect()->back()->with('success', 'Gallery dihapus!');
    }
}