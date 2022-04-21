<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'berat_barang',
        'merek',
        'stok',
        'harga_beli',
        'harga_jual',
        'diskon',
    ];
}
