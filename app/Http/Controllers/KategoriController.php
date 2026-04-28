<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    private $systemCategories = [
        'Processor', 'Motherboard', 'RAM', 'Casing', 'SSD', 'HDD', 
        'VGA', 'PSU', 'Mouse', 'Keyboard', 'Monitor', 'Cooler Fan'
    ];

    public function index()
    {
        $kategoris = Kategori::all();
        $systemCategories = $this->systemCategories;
        return view('admin.kategori.index', compact('kategoris', 'systemCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:kategoris,nama',
            'icon' => 'required|image|max:2048'
        ], [
            'icon.max' => 'Ukuran icon terlalu besar. Maksimal 2 MB.'
        ]);

        if ($request->file('icon')) {
            $validated['icon'] = $request->file('icon')->store('icons');
        }

        Kategori::create($validated);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $isSystem = in_array($kategori->nama, $this->systemCategories);

        if ($isSystem) {
            $validated = $request->validate([
                'icon' => 'nullable|image|max:2048'
            ], [
                'icon.max' => 'Ukuran icon terlalu besar. Maksimal 2 MB.'
            ]);
            $validated['nama'] = $kategori->nama;
        } else {
            $validated = $request->validate([
                'nama' => 'required|unique:kategoris,nama,'.$id,
                'icon' => 'nullable|image|max:2048'
            ], [
                'icon.max' => 'Ukuran icon terlalu besar. Maksimal 2 MB.'
            ]);
        }

        if ($request->file('icon')) {
            if ($kategori->icon) Storage::delete($kategori->icon);
            $validated['icon'] = $request->file('icon')->store('icons');
        }

        $kategori->update($validated);
        return redirect()->back()->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        if (in_array($kategori->nama, $this->systemCategories)) {
            return redirect()->back()->withErrors('Kategori sistem tidak dapat dihapus!');
        }

        if ($kategori->icon) Storage::delete($kategori->icon);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori dihapus!');
    }
}