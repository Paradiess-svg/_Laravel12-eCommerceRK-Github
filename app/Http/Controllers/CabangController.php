<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::latest()->get();
        return view('admin.cabang.index', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_cabang' => 'required|unique:cabangs,kode_cabang',
            'nama'        => 'required',
            'alamat'      => 'required',
            'deskripsi'   => 'nullable'
        ], [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah ada.',
        ]);

        Cabang::create($validated);

        return redirect()->back()->with('success', 'Cabang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $cabang = Cabang::findOrFail($id);

        $validated = $request->validate([
            'kode_cabang' => 'required|unique:cabangs,kode_cabang,'.$id,
            'nama'        => 'required',
            'alamat'      => 'required',
            'deskripsi'   => 'nullable'
        ], [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah ada.',
        ]);

        $cabang->update($validated);

        return redirect()->back()->with('success', 'Cabang berhasil diupdate!');
    }

    public function destroy($id)
    {
        Cabang::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Cabang berhasil dihapus!');
    }
}