<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    // (Index tidak perlu karena view ada di Dashboard)

    public function store(Request $request)
    {
        // KAMUS ERROR INDONESIA
        $messages = [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah terdaftar di sistem.',
            'email'    => 'Format email tidak valid.',
            'min'      => ':attribute minimal :min karakter.',
            'image'    => 'File harus berupa gambar.',
            'max'      => 'Ukuran file maksimal :max KB.',
        ];

        $validated = $request->validate([
            'kode_admin' => 'required|unique:users,kode_admin',
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'jk'         => 'required',
            'jabatan'    => 'required',
            'role'       => 'required',
            'id_cabang'  => 'nullable',
            'no_telfon'  => 'nullable',
            'alamat'     => 'nullable',
            'foto'       => 'nullable|image|max:2048'
        ], $messages); // <--- Masukkan kamus di sini

        $validated['password'] = Hash::make($request->password);

        if ($request->file('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos');
        }

        User::create($validated);

        return redirect()->route('dashboard')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $messages = [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah terdaftar.',
            'email'    => 'Format email tidak valid.',
            'min'      => ':attribute minimal :min karakter.',
            'image'    => 'File harus berupa gambar.',
            'max'      => 'Ukuran file maksimal :max KB.',
        ];

        $rules = [
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,'.$id,
            'jk'         => 'required',
            'jabatan'    => 'required',
            'role'       => 'required',
            'foto'       => 'nullable|image|max:2048'
        ];

        if($request->filled('password')){
            $rules['password'] = 'min:6';
        }

        $validated = $request->validate($rules, $messages); // <--- Masukkan kamus

        // Logic Update sama seperti sebelumnya...
        if($request->filled('password')){
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->kode_admin = $request->kode_admin;
        $user->no_telfon  = $request->no_telfon;
        $user->alamat     = $request->alamat;
        $user->id_cabang  = $request->id_cabang;
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->jk = $validated['jk'];
        $user->jabatan = $validated['jabatan'];
        $user->role = $validated['role'];
        if(isset($validated['password'])) $user->password = $validated['password'];

        if ($request->file('foto')) {
            if ($user->foto) Storage::delete($user->foto);
            $user->foto = $request->file('foto')->store('fotos');
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Data karyawan berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if($user->role == 'owner'){
            return redirect()->back()->with('error', 'Owner tidak bisa dihapus!');
        }

        if ($user->foto) Storage::delete($user->foto);
        $user->delete();

        return redirect()->route('dashboard')->with('success', 'Karyawan berhasil dihapus!');
    }
}