<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pembelian', 'id_product', 'jumlah', 'harga_beli', 'subtotal'
    ];

    public function products(){
        return $this->hasMany('App\Models\Product', 'id', 'id_product');
    }
}
