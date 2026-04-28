<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::latest()->get();
        return view('admin.hero.index', compact('heroes'));
    }

   public function store(Request $request)
    {
        // CEK SLOT PROMO & LARIS
        if ($request->status == 'promo' && Hero::where('status', 'promo')->exists()) {
            return redirect()->back()->withErrors(['status' => 'Gagal! Slot Promo sudah terisi. Hapus/Edit yang lama dulu.']);
        }
        if ($request->status == 'laris' && Hero::where('status', 'laris')->exists()) {
            return redirect()->back()->withErrors(['status' => 'Gagal! Slot Terlaris sudah terisi. Hapus/Edit yang lama dulu.']);
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah ada.',
            'image'    => 'File harus berupa gambar.',
            'max'      => 'Ukuran foto terlalu besar. Maksimal 10 MB.',
        ];

        $validated = $request->validate([
            'kode_hero' => 'required|unique:heroes,kode_hero',
            'judul'     => 'required',
            'deskripsi' => 'nullable',
            'link'      => 'nullable',
            'status'    => 'required',
            'foto'      => 'required|image|max:10240'
        ], $messages);

        $validated['link'] = $request->link ?? '#';

        if ($request->file('foto')) {
            $validated['foto'] = $request->file('foto')->store('hero-images');
        }

        Hero::create($validated);

        return redirect()->back()->with('success', 'Hero banner berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $hero = Hero::findOrFail($id);

        // CEK SLOT PROMO & LARIS (Kecuali punya diri sendiri)
        if ($request->status == 'promo' && Hero::where('status', 'promo')->where('id', '!=', $id)->exists()) {
            return redirect()->back()->withErrors(['status' => 'Gagal! Slot Promo sudah terisi.']);
        }
        if ($request->status == 'laris' && Hero::where('status', 'laris')->where('id', '!=', $id)->exists()) {
            return redirect()->back()->withErrors(['status' => 'Gagal! Slot Terlaris sudah terisi.']);
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah ada.',
            'image'    => 'File harus berupa gambar.',
            'max'      => 'Ukuran foto terlalu besar. Maksimal 10 MB.',
        ];

        $rules = [
            'judul'     => 'required',
            'deskripsi' => 'nullable',
            'link'      => 'nullable',
            'status'    => 'required',
            'foto'      => 'nullable|image|max:10240'
        ];

        if($request->kode_hero != $hero->kode_hero){
            $rules['kode_hero'] = 'required|unique:heroes,kode_hero';
        }

        $validated = $request->validate($rules, $messages);
        $validated['link'] = $request->link ?? '#';

        if ($request->file('foto')) {
            if ($hero->foto) Storage::delete($hero->foto);
            $validated['foto'] = $request->file('foto')->store('hero-images');
        }

        $hero->update($validated);

        return redirect()->back()->with('success', 'Hero banner berhasil diupdate!');
    }

    public function destroy($id)
    {
        $hero = Hero::findOrFail($id);
        if ($hero->foto) Storage::delete($hero->foto);
        $hero->delete();
        return redirect()->back()->with('success', 'Hero banner dihapus!');
    }
}