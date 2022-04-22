<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = Penjualan::orderBy('id', 'desc')->get();

        return view('penjualan.index', compact('penjualan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penjualan = new Penjualan();
        $penjualan->id_customer = Auth::user()->hasRole('customer') ? Auth::user()->id : null;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = Auth::user()->id;

        $penjualan->save();

        session([
            'id_penjualan' => $penjualan->id,
        ]);

        return redirect()->route('transaksi.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        $penjualan->total_item = $request->total_item;
        $penjualan->id_customer = $request->id_customer;
        $penjualan->total_harga = $request->total;
        $penjualan->diskon = $request->diskon;
        $penjualan->bayar = $request->bayar;
        $penjualan->diterima = $request->diterima;

        $penjualan->update();

        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id)->get();
        foreach ($detail as $item) {
            $product = Product::findOrFail($item->id_product);
            $product->stok -= $item->jumlah;
            $product->update();
        }

        $request->session()->flash('success', 'Transaksi Penjualan tersimpan');

        return redirect()->route('penjualan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PenjualanDetail::with('products')->where('id_penjualan', $id)->get();

        $data = [];

        foreach($detail as $item) {
            array_push($data, [
            'kode_barang' => $item->products[0]['kode_barang'],
            'nama_barang' => $item->products[0]['nama_barang'],
            'harga_jual' => $item->harga_jual,
            'jumlah' => $item->jumlah,
            'subtotal' => $item->subtotal
            ]);
        }

        return response()->json($data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenjualanRequest  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id)->get();
        foreach ($detail as $item) {
            $product = Product::findOrFail($item->id_product);
            $product->stok += $item->jumlah;
            $product->update();
            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }

    public function notaKecil(){
        $penjualan = Penjualan::findOrFail(session('id_penjualan'));
        $detail = PenjualanDetail::with('products')->where('id_penjualan', $penjualan->id)->get();

        $data = [];

        foreach($detail as $item) {
            array_push($data, [
            'kode_barang' => $item->products[0]['kode_barang'],
            'nama_barang' => $item->products[0]['nama_barang'],
            'harga_jual' => $item->harga_jual,
            'jumlah' => $item->jumlah,
            'subtotal' => $item->subtotal
            ]);
        }

        return view('penjualan.nota-kecil', compact('penjualan', 'data'));
    }

    public function notaBesar(){

    }
}
