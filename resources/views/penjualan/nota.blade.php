<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Nota</title>

    <?php
    $style = '
            <style>
            * {
                font-family: "consolas";
            }
            p {
                display: block;
                margin: 3px;
                font-size: 10pt;
            }

            table td {
                font-size: 9pt;
            }
            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            @media print {
                @page {
                    margin: 0;
                    size: 75mm ';
    $style .= !empty($_COOKIE['innerHeight']) ? $_COOKIE['innerHeight'] . 'mm;' : '';

    $style .= '
                }
                html, body {
                    width: 70mm;
                }
                .btn-print {
                    display: none;
                }
            }
        </style>';
    ?>

    {!! $style !!}
</head>

<body>
    <button class="btn-print" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">{{ Str::upper(config('app.name')) }}</p>
            <p>{{ Str::upper(config('app.alamat')) }}</p>
    </div>
    <br>

    <div>
        <p style="float: left;">{{ date('d-m-Y') }}</p>
        <p style="float: right;">{{ Str::upper(Auth::user()->name) }}</p>
    </div>
    <div class="clear-float" style="clear: both;"></div>
    <p class="text-center">======================================</p>
    <p>No: {{ tambah_nol_didepan($penjualan->id, 6) }}</p>
    <table width="100%" style="border: 0;">
        @foreach ($data as $item)
            <tr>
                <td colspan="3">{{ $item['nama_barang'] }}</td>
            </tr>
            <tr>
                <td>{{ $item['jumlah'] }} x {{ format_uang($item['harga_jual']) }}</td>
                <td></td>
                <td class="text-right">{{ format_uang($item['jumlah'] * $item['harga_jual']) }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">======================================</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga</td>
            <td class="text-right">{{ format_uang($penjualan->total_harga) }}</td>
        </tr>
        <tr>
            <td>Total Item</td>
            <td class="text-right">{{ $penjualan->total_item }}</td>
        </tr>
        <tr>
            <td>Diskon</td>
            <td class="text-right">{{ $penjualan->diskon }}</td>
        </tr>
        <tr>
            <td>Total Bayar</td>
            <td class="text-right">{{ format_uang($penjualan->bayar) }}</td>
        </tr>
        <tr>
            <td>Diterimar</td>
            <td class="text-right">{{ format_uang($penjualan->diterima) }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</td>
        </tr>
    </table>

    <p class="text-center">======================================</p>

    <p class="text-center">--- TERIMA KASIH ---</p>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html
        .offsetHeight);

        let result = ((height + 50) * 0.264583);

        document.cookie = 'innerHeight=' + result + '; path=/';
    </script>
</body>

</html>
