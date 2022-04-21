<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PembelianDetail;
use App\Http\Requests\StorePembelianDetailRequest;
use App\Http\Requests\UpdatePembelianDetailRequest;

class PembelianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $products = Product::orderBy('nama_barang', 'asc')->get();
        $supplier = Supplier::findOrFail(session('id_supplier'));

        return view('pembelian_detail.index', compact('id_pembelian', 'products', 'supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembelianDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $product = Product::where('id', $request->id_product)->first();

        PembelianDetail::create([
            'id_pembelian' => $request->id_pembelian,
            'id_product' => $product->id,
            'harga_beli' => $product->harga_beli,
            'jumlah' => 1,
            'subtotal' => $product->harga_beli
        ]);

        return response()->json('Data berhasil ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = json_decode(PembelianDetail::with('products')->where('id_pembelian', $id)->get());

        $total = 0;
        $total_item = 0;

        foreach ($detail as $key => $item) {
            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }

        array_push($detail, [
            'harga_beli'  => '',
            'jumlah'      => '',
            'subtotal'    => '<div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'products'     => '',
            'id' => '0'
        ]);

        return response()->json($detail, 200);
    }

    public function loadform($diskon, $total){
        $bayar = $total - ($total * $diskon / 100);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah')
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembelianDetailRequest  $request
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = PembelianDetail::findOrFail($id);
        $data->jumlah = $request->jumlah;
        $data->subtotal = $data->harga_beli * $request->jumlah;
        $data->update();

        return response()->json('Data berhasil diubah', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PembelianDetail::findOrFail($id);
        $data->delete();

        return response()->json('Data berhasil dihapus', 200);
    }
}
