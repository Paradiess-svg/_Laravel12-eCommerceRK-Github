<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'id_produk',
        'foto',
        'deskripsi' // <--- SUDAH DIPERBAIKI (Tadinya 'desk')
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}