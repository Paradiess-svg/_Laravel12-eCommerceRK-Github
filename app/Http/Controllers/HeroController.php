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
            'status'    => 'required|in:aktif,nonaktif,promo,laris',
            'foto'      => 'required|image|mimes:jpg,jpeg,png|max:10240'
        ], $messages + ['foto.mimes' => 'Foto harus berformat PNG atau JPG.']);

        $validated['link'] = $request->link ?? '#';

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('hero-images', config('filesystems.upload_disk'));
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
            'kode_hero' => 'required|unique:heroes,kode_hero,'.$id,
            'judul'     => 'required',
            'deskripsi' => 'nullable',
            'link'      => 'nullable',
            'status'    => 'required|in:aktif,nonaktif,promo,laris',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:10240'
        ];

        $validated = $request->validate($rules, $messages + ['foto.mimes' => 'Foto harus berformat PNG atau JPG.']);
        $validated['link'] = $request->link ?? '#';

        if ($request->hasFile('foto')) {
            $disk = config('filesystems.upload_disk');
            if ($hero->foto) Storage::disk($disk)->delete($hero->foto);
            $validated['foto'] = $request->file('foto')->store('hero-images', $disk);
        }

        $hero->update($validated);

        return redirect()->back()->with('success', 'Hero banner berhasil diupdate!');
    }

    public function destroy($id)
    {
        $hero = Hero::findOrFail($id);
        if ($hero->foto) Storage::disk(config('filesystems.upload_disk'))->delete($hero->foto);
        $hero->delete();
        return redirect()->back()->with('success', 'Hero banner dihapus!');
    }
}