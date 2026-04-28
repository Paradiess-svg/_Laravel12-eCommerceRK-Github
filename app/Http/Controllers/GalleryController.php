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
        $validated = $request->validate([
            'id_produk' => 'required',
            'deskripsi' => 'nullable', // <--- GANTI JADI deskripsi
            'foto'      => 'required|image|max:2048'
        ], [
            'required' => ':attribute wajib diisi.',
            'image'    => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto terlalu besar. Maksimal 2 MB.'
        ]);

        if ($request->file('foto')) {
            $validated['foto'] = $request->file('foto')->store('gallery-images');
        }

        Gallery::create($validated);

        return redirect()->back()->with('success', 'Foto gallery berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'id_produk' => 'required',
            'deskripsi' => 'nullable', // <--- GANTI JADI deskripsi
            'foto'      => 'nullable|image|max:2048'
        ], [
            'foto.max' => 'Ukuran foto terlalu besar. Maksimal 2 MB.'
        ]);

        if ($request->file('foto')) {
            if ($gallery->foto) Storage::delete($gallery->foto);
            $validated['foto'] = $request->file('foto')->store('gallery-images');
        }

        $gallery->update($validated);

        return redirect()->back()->with('success', 'Gallery berhasil diupdate!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->foto) Storage::delete($gallery->foto);
        $gallery->delete();
        return redirect()->back()->with('success', 'Gallery dihapus!');
    }
}