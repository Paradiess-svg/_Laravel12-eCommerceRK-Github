<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
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
            'icon' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'icon.max' => 'Ukuran icon terlalu besar. Maksimal 2 MB.',
            'icon.mimes' => 'Icon harus berformat PNG atau JPG.'
        ]);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('icons', config('filesystems.upload_disk'));
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
                'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ], [
                'icon.max' => 'Ukuran icon terlalu besar. Maksimal 2 MB.',
                'icon.mimes' => 'Icon harus berformat PNG atau JPG.'
            ]);
            $validated['nama'] = $kategori->nama;
        } else {
            $validated = $request->validate([
                'nama' => 'required|unique:kategoris,nama,'.$id,
                'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ], [
                'icon.max' => 'Ukuran icon terlalu besar. Maksimal 2 MB.',
                'icon.mimes' => 'Icon harus berformat PNG atau JPG.'
            ]);
        }

        if ($request->hasFile('icon')) {
            $disk = config('filesystems.upload_disk');
            if ($kategori->icon) Storage::disk($disk)->delete($kategori->icon);
            $validated['icon'] = $request->file('icon')->store('icons', $disk);
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

        // Jangan biarkan produk ikut terhapus karena foreign key cascade.
        if (Produk::where('id_kategori', $kategori->id)->exists()) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh produk.');
        }

        if ($kategori->icon) Storage::disk(config('filesystems.upload_disk'))->delete($kategori->icon);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori dihapus!');
    }
}