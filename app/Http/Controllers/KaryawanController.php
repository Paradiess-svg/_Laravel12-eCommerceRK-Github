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

    /**
     * Hanya owner/super admin yang boleh mengelola data karyawan.
     */
    private function ensureCanManage(): void
    {
        if (Auth::user()->role === 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengelola data karyawan.');
        }
    }

    public function store(Request $request)
    {
        $this->ensureCanManage();

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
            'jk'         => 'required|in:L,P',
            'jabatan'    => 'required',
            'role'       => 'required|in:admin,super_admin',
            'id_cabang'  => 'nullable|exists:cabangs,id',
            'no_telfon'  => 'nullable',
            'alamat'     => 'nullable',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], $messages); // <--- Masukkan kamus di sini

        $validated['password'] = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', config('filesystems.upload_disk'));
        }

        User::create($validated);

        return redirect()->route('dashboard')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $this->ensureCanManage();

        $user = User::findOrFail($id);

        // Akun owner hanya boleh diubah oleh owner itu sendiri.
        if ($user->role === 'owner' && Auth::id() !== $user->id) {
            return redirect()->back()->with('error', 'Data owner tidak bisa diubah oleh akun lain!');
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah terdaftar.',
            'email'    => 'Format email tidak valid.',
            'min'      => ':attribute minimal :min karakter.',
            'image'    => 'File harus berupa gambar.',
            'max'      => 'Ukuran file maksimal :max KB.',
        ];

        $rules = [
            'kode_admin' => 'required|unique:users,kode_admin,'.$id,
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,'.$id,
            'jk'         => 'required|in:L,P',
            'jabatan'    => 'required',
            'role'       => 'required|in:admin,super_admin',
            'id_cabang'  => 'nullable|exists:cabangs,id',
            'no_telfon'  => 'nullable',
            'alamat'     => 'nullable',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
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

        if ($request->hasFile('foto')) {
            $disk = config('filesystems.upload_disk');
            if ($user->foto) Storage::disk($disk)->delete($user->foto);
            $validated['foto'] = $request->file('foto')->store('fotos', $disk);
        }

        $user->update($validated);

        return redirect()->route('dashboard')->with('success', 'Data karyawan berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $this->ensureCanManage();

        $user = User::findOrFail($id);
        
        if($user->role == 'owner'){
            return redirect()->back()->with('error', 'Owner tidak bisa dihapus!');
        }

        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        if ($user->foto) Storage::disk(config('filesystems.upload_disk'))->delete($user->foto);
        $user->delete();

        return redirect()->route('dashboard')->with('success', 'Karyawan berhasil dihapus!');
    }
}