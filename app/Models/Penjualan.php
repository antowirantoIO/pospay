<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $fillable = [
        'total_item', 'total_harga', 'diskon', 'bayar', 'diterima', 'id_user'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function customer(){
        return $this->belongsTo('App\Models\User', 'id_customer', 'id_customer');
    }

    public function detail_penjualan()
    {
        return $this->hasMany('App\Models\PenjualanDetail', 'id_penjualan');
    }
}
