<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    // Izinkan kolom ini diisi manual (sesuai DB)
    protected $fillable = [
        'kode_hero',
        'judul',
        'foto',
        'deskripsi',
        'link',
        'status'
    ];
}