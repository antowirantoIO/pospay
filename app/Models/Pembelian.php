<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $fillable = [
        'supplier_id', 'total_item', 'total_harga', 'diskon', 'bayar'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function detail_pembelian()
    {
        return $this->hasMany(PembelianDetail::class, 'id_pembelian');
    }
}
