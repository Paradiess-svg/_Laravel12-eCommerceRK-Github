<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RakitPc extends Model
{
    protected $fillable = [
        'kode_rakitan',
        'processor', 
        'motherboard',
        'ram',
        'casing',
        'ssd',
        'hdd',
        'vga',
        'psu',
        'mouse',
        'keyboard',
        'monitor',
        'coolerfan',
        'total_harga'
    ];
}