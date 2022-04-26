<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'data' => $this->_getDataMonth(),
        ]);
    }

    private function _getDataMonth(){
        $penjualan = Penjualan::whereBetween('created_at', ['2022-04-01', '2022-04-30'])->get();
        $pembelian = Pembelian::whereBetween('created_at', ['2022-04-01', '2022-04-30'])->get();

        $modal = 0;
        $pemasukan = 0;
        $pengeluaran = 0;

        foreach ($pembelian as $item) {
            $pengeluaran += $item->bayar;
        }

        foreach($penjualan as $p){
            foreach ($p->detail_penjualan as $dp) {
                $modal += $dp->products[0]->harga_beli * $dp->jumlah;
            }
            $pemasukan += $p->bayar;
        }

        return [
            'penjualan' => $penjualan,
            'pembelian' => $pembelian,
            'pengeluaran' => format_uang($pengeluaran),
            'modal' => format_uang($modal),
            'pemasukan' => format_uang($pemasukan),
            'estimated' => format_uang(($modal - $pengeluaran) + $pemasukan)
        ];
    }
}
