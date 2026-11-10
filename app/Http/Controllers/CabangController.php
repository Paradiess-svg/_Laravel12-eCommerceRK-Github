<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Produk;
use App\Models\User;
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
        $cabang = Cabang::findOrFail($id);

        // Jangan biarkan produk/karyawan ikut terhapus atau kehilangan cabang
        // karena foreign key cascade/nullOnDelete.
        if (Produk::where('id_cabang', $cabang->id)->exists()) {
            return redirect()->back()->with('error', 'Cabang tidak bisa dihapus karena masih memiliki produk.');
        }

        if (User::where('id_cabang', $cabang->id)->exists()) {
            return redirect()->back()->with('error', 'Cabang tidak bisa dihapus karena masih memiliki karyawan.');
        }

        $cabang->delete();
        return redirect()->back()->with('success', 'Cabang berhasil dihapus!');
    }
}