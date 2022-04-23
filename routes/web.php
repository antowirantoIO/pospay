<?php

use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/data', function () {
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
        'pengeluaran' => $pengeluaran,
        'modal' => $modal,
        'pemasukan' => $pemasukan,
        'estimated' => $modal + $pemasukan - $pengeluaran
    ];
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
        Route::get('/product/{product:kode_barang}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
        Route::patch('/product/{product:kode_barang}/update', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{product:kode_barang}/delete', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.delete');

        Route::get('/supplier', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/supplier/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier/store', [App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{supplier:id}/edit', [App\Http\Controllers\SupplierController::class, 'edit'])->name('supplier.edit');
        Route::patch('/supplier/{supplier:id}/update', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{supplier:id}/delete', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.delete');

        Route::get('/pembelian', [App\Http\Controllers\PembelianController::class, 'index'])->name('pembelian.index');
        Route::get('/pembelian/show/{id}', [App\Http\Controllers\PembelianController::class, 'show'])->name('pembelian.show');
        Route::get('/pembelian/create/{id}', [App\Http\Controllers\PembelianController::class, 'create'])->name('pembelian.create');
        Route::post('/pembelian/store', [App\Http\Controllers\PembelianController::class, 'store'])->name('pembelian.store');
        Route::delete('/pembelian/{id}/delete', [App\Http\Controllers\PembelianController::class, 'destroy'])->name('pembelian.delete');

        Route::get('/pembelian-detail', [App\Http\Controllers\PembelianDetailController::class, 'index'])->name('pembelian_detail.index');
        Route::post('/pembelian-detail/store', [App\Http\Controllers\PembelianDetailController::class, 'store'])->name('pembelian_detail.store');
        Route::get('/pembelian-detail/{id}/show', [App\Http\Controllers\PembelianDetailController::class, 'show'])->name('pembelian_detail.show');
        Route::patch('/pembelian-detail/{id}/update', [App\Http\Controllers\PembelianDetailController::class, 'update'])->name('pembelian_detail.update');
        Route::delete('/pembelian-detail/{id}/delete', [App\Http\Controllers\PembelianDetailController::class, 'destroy'])->name('pembelian_detail.delete');
        Route::get('/pembelian-detail/loadform/{diskon}/{total}', [App\Http\Controllers\PembelianDetailController::class, 'loadform'])->name('pembelian_detail.loadform');
    });

    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');

    Route::get('transaksi/nota-kecil', [App\Http\Controllers\PenjualanController::class, 'notaKecil'])->name('transaksi.notaKecil');
    Route::get('transaksi/nota-besar', [App\Http\Controllers\PenjualanController::class, 'notaBesar'])->name('transaksi.notaBesar');

    Route::get('penjualan', [App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('penjualan/data', [App\Http\Controllers\PenjualanController::class, 'data'])->name('penjualan.data');
    Route::get('penjualan/{id}', [App\Http\Controllers\PenjualanController::class, 'show'])->name('penjualan.show');
    Route::delete('penjualan/{id}/delete', [App\Http\Controllers\PenjualanController::class, 'destroy'])->name('penjualan.delete');

    Route::get('/transaksi/new', [App\Http\Controllers\PenjualanController::class, 'create'])->name('transaksi.new');
    Route::post('/transaksi/simpan', [App\Http\Controllers\PenjualanController::class, 'store'])->name('transaksi.simpan');

    Route::get('/transaksi/show/{id}', [App\Http\Controllers\PenjualanDetailController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi', [App\Http\Controllers\PenjualanDetailController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/store', [App\Http\Controllers\PenjualanDetailController::class, 'store'])->name('transaksi.store');
    Route::patch('/transaksi/{id}/update', [App\Http\Controllers\PenjualanDetailController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}/delete', [App\Http\Controllers\PenjualanDetailController::class, 'destroy'])->name('transaksi.delete');
    Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [App\Http\Controllers\PenjualanDetailController::class, 'loadform'])->name('transaksi.loadform');
});
