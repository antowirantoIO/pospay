<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penjualan', 'id_product', 'harga_jual', 'jumlah', 'harga', 'diskon', 'subtotal'
    ];

    public function products(){
        return $this->hasMany('App\Models\Product', 'id', 'id_product');
    }

    public function member(){
        return $this->belongsTo('App\Models\User', 'id_member', 'id');
    }

    public function penjualan(){
        return $this->belongsTo('App\Models\Penjualan', 'id_penjualan', 'id');
    }
}
