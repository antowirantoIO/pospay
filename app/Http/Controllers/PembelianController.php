<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\PembelianDetail;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('nama', 'asc')->get();
        $pembelian = Pembelian::orderBy('id', 'desc')->get();
        return view('pembelian.index', compact('suppliers', 'pembelian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pembelian = new Pembelian;
        $pembelian->id_supplier = $id;
        $pembelian->total_item = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;
        $pembelian->bayar = 0;
        $pembelian->save();

        session([
            'id_pembelian' => $pembelian->id,
            'id_supplier' => $id
        ]);

        return redirect()->route('pembelian_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->id_pembelian);
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->diskon = $request->diskon;
        $pembelian->bayar = $request->bayar;

        $pembelian->update();

        $detail = PembelianDetail::where('id_pembelian', $pembelian->id)->get();
        foreach ($detail as $item) {
            $product = Product::findOrFail($item->id_product);
            $product->stok += $item->jumlah;
            $product->update();
        }

        session()->forget('id_pembelian', 'id_supplier');

        return redirect()->route('pembelian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PembelianDetail::with('products')->where('id_pembelian', $id)->get();

        $data = [];

        foreach($detail as $item) {
            array_push($data, [
            'kode_barang' => $item->products[0]['kode_barang'],
            'nama_barang' => $item->products[0]['nama_barang'],
            'harga_beli' => format_uang($item->harga_beli),
            'jumlah' => $item->jumlah,
            'subtotal' => format_uang($item->subtotal)
            ]);
        }

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembelianRequest  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembelianRequest $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $detail = PembelianDetail::where('id_pembelian', $pembelian->id)->get();
        foreach ($detail as $item) {
            $product = Product::findOrFail($item->id_product);
            $product->stok -= $item->jumlah;
            $product->update();
            $item->delete();
        }

        $pembelian->delete();

        return response(null, 204);
    }
}
