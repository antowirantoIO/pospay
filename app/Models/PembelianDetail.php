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
        return $this->belongsTo('App\Models\Product', 'id_product', 'id');
    }

    public function member(){
        return $this->belongsTo('App\Models\User', 'id_member', 'id');
    }

    public function pembelian(){
        return $this->belongsTo('App\Models\Pembelian', 'id_pembelian', 'id');
    }
}
