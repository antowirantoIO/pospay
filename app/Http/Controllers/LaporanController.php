<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        return view('laporan.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function getDataMonth($tanggalAwal, $tanggalAkhir){
        $no = 0;
        $data = [];
        $pendapatan = 0;
        $pengeluaran = 0;
        $total_pendapatan = 0;

        while (strtotime($tanggalAwal) <= strtotime($tanggalAkhir)) {
            $tanggal = $tanggalAwal;
            $tanggalAwal = date('Y-m-d', strtotime("+1 day", strtotime($tanggalAwal)));

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');

            $pendapatan = $total_penjualan - $total_pembelian;
            $total_pendapatan += $pendapatan;

            $row = [
                'no' => ++$no,
                'tanggal' => date('d F Y', strtotime($tanggal)),
                'total_penjualan' => format_uang($total_penjualan),
                'total_pembelian' => format_uang($total_pembelian),
                'pendapatan' => format_uang($pendapatan),
            ];

            $data[] = $row;
        }

        $data[] = [
            'no' => '',
            'tanggal' => '',
            'total_penjualan' => '',
            'total_pembelian' => 'Total Pendapatan',
            'pendapatan' => format_uang($total_pendapatan),
        ];

        return $data;
    }

    public function refresh(Request $request){
        $tanggalAwal = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        return view('laporan.index', compact('tanggalAwal', 'tanggalAkhir'));
    }
}
