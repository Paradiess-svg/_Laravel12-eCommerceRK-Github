<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cabang;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT CABANG DULU (PENTING BUAT RELASI)
        $cabangSerang = Cabang::create([
            'kode_cabang' => 'S01',
            'nama' => 'Ratu Komputer Serang',
            'alamat' => 'Jl. Ciwaru Raya No.Rt.04/16, Cipare, Kota Serang',
            'deskripsi' => 'Cabang Pusat'
        ]);

        $cabangBogor = Cabang::create([
            'kode_cabang' => 'B01',
            'nama' => 'Ratu Komputer Bogor',
            'alamat' => 'Ruko Villa Indah Pajajaran, Kota Bogor',
            'deskripsi' => 'Cabang Bogor'
        ]);

        // 2. BUAT KATEGORI (SAMPLE AJA)
        $kategoriList = ['Processor', 'Motherboard', 'RAM', 'Casing', 'SSD', 'HDD', 'VGA', 'PSU', 'Mouse', 'Keyboard', 'Monitor', 'Cooler Fan'];
        foreach ($kategoriList as $kat) {
            Kategori::create([
                'nama' => $kat,
                'icon' => strtolower($kat) . '.png' // dummy icon
            ]);
        }

        // 3. BUAT USER (SESUAI FILE SQL KAMU)
        // Password semua akun: 123

        // ADMIN BIASA (Dean - Cabang Serang)
        User::create([
            'kode_admin' => 'K001',
            'id_cabang' => $cabangSerang->id, // Admin Serang
            'name' => 'Dean Naufal',
            'email' => 'dnaufal@gmail.com',
            'password' => Hash::make('123'),
            'jabatan' => 'Staff',
            'role' => 'admin',
            'jk' => 'L',
            'no_telfon' => '081233329906',
            'alamat' => 'Bogor'
        ]);

        // ADMIN BIASA (Dean - Cabang Bogor - Akun kedua)
        User::create([
            'kode_admin' => 'K001-B',
            'id_cabang' => $cabangBogor->id, // Admin Bogor
            'name' => 'Dean Naufal (Bogor)',
            'email' => 'dnaufal_bogor@gmail.com',
            'password' => Hash::make('123'),
            'jabatan' => 'Staff',
            'role' => 'admin',
            'jk' => 'L'
        ]);

        // SUPER ADMIN (Beti - Bisa akses semua, tapi terdaftar di Serang)
        User::create([
            'kode_admin' => 'K002',
            'id_cabang' => $cabangSerang->id,
            'name' => 'Beti Putri',
            'email' => 'mrsbest@gmail.com',
            'password' => Hash::make('123'),
            'jabatan' => 'Staff Senior',
            'role' => 'super_admin',
            'jk' => 'P',
            'no_telfon' => '082186407595'
        ]);

        // OWNER (Rijaludin - THE GOD)
        User::create([
            'kode_admin' => 'RK1',
            'id_cabang' => $cabangSerang->id, // Owner biasanya di pusat
            'name' => 'Rijaludin',
            'email' => 'ratukomputer@gmail.com',
            'password' => Hash::make('123'),
            'jabatan' => 'CEO',
            'role' => 'owner',
            'jk' => 'L',
            'no_telfon' => '087773599434'
        ]);

        // 4. SAMPLE PRODUK (Biar Dashboard gak sepi)
        Produk::create([
            'kode_produk' => 'BRG001',
            'id_cabang' => $cabangSerang->id,
            'id_kategori' => 7, // VGA
            'nama' => 'ASUS ROG Strix G16',
            'deskripsi' => 'Laptop gaming terbaik',
            'harga' => 19999999,
            'stok' => 5
        ]);
    }
}