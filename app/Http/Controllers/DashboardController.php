<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $pemasukan = 0;
    public $pengeluaran = 0;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $penjualan = Penjualan::whereMonth('created_at', date('m'))->get();
        $pembelian = Pembelian::whereMonth('created_at', date('m'))->get();
        $user = User::whereMonth('created_at', date('m'))->get();

        $this->_calculate($penjualan, $pembelian);

        return view('dashboard', [
            'penjualanCount' => $penjualan->count(),
            'pembelianCount' => $pembelian->count(),
            'userCount' => $user->count(),
            'estimasiLabaBulan' => format_uang($this->pemasukan - $this->pengeluaran),
            'estimasiLaba' => format_uang($this->_getPenghasilan()),
            'penjualanAll' => $this->_getSales(),
            'barangLowStok' => $this->_getBarangLowStok(),
            'dataChartLaporan' => $this->_getDataLaporanTahunan(),
        ]);
    }

    private function _getBarangLowStok(){
        return Product::where('stok', '<=', 5)->get();
    }

    private function _getSales(){
        return Penjualan::all()->count();;
    }

    private function _getPenghasilan(){
        $penjualan = Penjualan::all();
        $pembelian = Pembelian::all();

        $this->_calculate($penjualan, $pembelian);

        return ($this->pemasukan - $this->pengeluaran);
    }

    private function _getDataLaporanTahunan(){
        $pembelian = Pembelian::select(DB::raw("SUM(total_harga) as count_harga"), DB::raw("MONTH(created_at) as bulan"))
                    ->orderBy("created_at")
                    ->groupBy(DB::raw("month(created_at)"))
                    ->get()->toArray();
        $pembelian = array_column($pembelian, 'count_harga', 'bulan');

        $dataPembelian = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach($pembelian as $key => $value){
            $dataPembelian[$key] = (int)$value;
        }

        $penjualan = Penjualan::select(DB::raw("SUM(total_harga) as count_harga"), DB::raw("MONTH(created_at) as bulan"))
                    ->orderBy("created_at")
                    ->groupBy(DB::raw("month(created_at)"))
                    ->get()->toArray();
        $penjualan = array_column($penjualan, 'count_harga', 'bulan');

        $dataPenjualan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach($penjualan as $key => $value){
            $dataPenjualan[$key] = (int)$value;
        }

        return [
            'dataPembelian' => $dataPembelian,
            'dataPenjualan' => $dataPenjualan,
        ];
    }

    private function _calculate($penjualan, $pembelian){
        $pemasukan = 0;
        $pengeluaran = 0;

        foreach ($pembelian as $item) {
            $pengeluaran += $item->bayar;
        }

        foreach($penjualan as $p){
            $pemasukan += $p->bayar;
        }

        $this->pemasukan = $pemasukan;
        $this->pengeluaran = $pengeluaran;
    }
}
