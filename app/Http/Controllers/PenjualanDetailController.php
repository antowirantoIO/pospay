<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use App\Http\Requests\StorePenjualanDetailRequest;
use App\Http\Requests\UpdatePenjualanDetailRequest;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('nama_barang')->get();
        $customers = User::role('customer')->orderBy('name')->get();

        if($id_penjualan = session('id_penjualan')){
            return view('penjualan_detail.index', compact('products', 'customers', 'id_penjualan'));
        }

        return redirect()->route('transaksi.new');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pernjualan = new Penjualan();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenjualanDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::where('id', $request->id_product)->first();

        PenjualanDetail::create([
            'id_penjualan' => $request->id_penjualan,
            'id_product' => $product->id,
            'harga_jual' => $product->harga_jual,
            'jumlah' => 1,
            'diskon' => 0,
            'subtotal' => $product->harga_jual
        ]);

        return response()->json('Data berhasil ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = json_decode(PenjualanDetail::with('products')->where('id_penjualan', $id)->get());

        $total = 0;
        $total_item = 0;

        foreach ($detail as $key => $item) {
            $total += $item->harga_jual * $item->jumlah;
            $total_item += $item->jumlah;
        }

        array_push($detail, [
            'harga_jual'  => '',
            'jumlah'      => '',
            'diskon'      => '',
            'subtotal'    => '<div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'products'     => '',
            'id' => '0'
        ]);

        return response()->json($detail, 200);
    }

    public function loadform($diskon = 0, $total, $diterima)
    {
        $bayar = $total - ($total * $diskon / 100);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang(($diterima != 0) ? $bayar - $diterima : 0),
            'kembali_terbilang' => ucwords(terbilang(($diterima != 0) ? $bayar - $diterima : 0). ' Rupiah'),
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenjualanDetailRequest  $request
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenjualanDetailRequest $request, PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(PenjualanDetail $penjualanDetail)
    {
        //
    }
}
