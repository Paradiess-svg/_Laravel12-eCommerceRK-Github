<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // Izinkan kolom ini diisi manual
protected $fillable = [
    'kode_produk',
    'id_cabang',
    'id_kategori',
    'nama',
    'deskripsi', // <--- UBAH INI (Tadinya 'desk')
    'harga',
    'stok',
    'foto'
];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi ke Cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function gallery()
    {
        // Satu Produk punya BANYAK foto di Gallery
        return $this->hasMany(Gallery::class, 'id_produk');
    }
}