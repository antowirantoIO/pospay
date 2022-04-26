<x-dashboard title="Manage data Penjualan">
    <x-slot name="css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/datatables.net-select-bs4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs/themes/prism.css">
    </x-slot>
    <div class="section-header">
        <h1>Kelola Data penjualan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Data penjualan</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Data penjualan</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        <div class="pb-2">
                            @if (config('app.tipe_nota') == 0)
                                <button onclick="notaKecil()" class="btn btn-primary">Cetak Nota</button>
                            @else
                                <button onclick="notaBesar()" class="btn btn-primary">Cetak Nota</button>
                            @endif
                            <a href="{{ route('transaksi.new') }}" class="btn btn-primary">Transaksi Pemjualan Baru</a>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-data">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Diskon</th>
                                    <th>Total Bayar</th>
                                    <th>Kasir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualan as $item)
                                    <tr>
                                        <td class="text-center">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    class="custom-control-input" id="checkbox-1">
                                                <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{ tanggal_indonesia($item->created_at) }}</td>
                                        <td>{{ $item->customer->name }}</td>
                                        <td>{{ $item->total_item }}</td>
                                        <td>Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $item->diskon }} %</td>
                                        <td>Rp. {{ number_format($item->bayar, 0, ',', '.') }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td class="items-center">
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"
                                                        onclick="showDetails('{{ route('penjualan.show', $item->id) }}')"
                                                        href="
                                                        #"><i class="fas fa-eye text-info pr-2"></i> Show </a>
                                                    <a class="dropdown-item"
                                                        onclick="deleteDetails('{{ route('penjualan.delete', $item->id) }}')"
                                                        href="
                                                        #"><i class="fas fa-trash text-danger pr-2"></i> Delete </a>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="modal">

        <div class="modal fade" id="modal-detail" tabindex="-5" role="dialog" aria-labelledby="modal-detail">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Barang penjualan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-detail">
                                <thead>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <td>Jumlah</td>
                                    <td>Subtotal</td>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="js">
        <script src="https://cdn.jsdelivr.net/npm/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/prismjs/prism.js"></script>
        <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

        <script>
            $("#table-data").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [0, 2, 3]
                }]
            });

            let table_detail = $("#table-detail").DataTable({
                autoWidth: false,
                "columnDefs": [{
                    "sortable": false,
                    "targets": [0, 2, 3, 4, 5]
                }],
                dom: 'Bfrt',
            });

            function showDetails(url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        table_detail.clear().draw();
                        table_detail.ajax.url(url);
                        table_detail.ajax.dataSrc = data;
                        $.each(data, function(index, item) {
                            table_detail.row.add([
                                index + 1,
                                item.kode_barang,
                                item.nama_barang,
                                item.harga_jual,
                                item.jumlah,
                                item.subtotal
                            ]).draw();
                        });

                        $('#modal-detail').modal('show');
                    }
                });
                $('#modal-detail').modal('show');
            }

            function deleteDetails(url) {
                swal({
                    title: "Apakah anda yakin?",
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                swal("Berhasil!", "success");
                                location.reload();
                            }
                        });
                    }
                });
            }

            function notaKecil(){
                popupCenter('{{ route('transaksi.notaKecil') }}', 'Nota Kecil PDF', 720, 674);
            }

            function notaBesar(){
                popupCenter('{{ route('transaksi.notaBesar') }}', 'Nota Kecil PDF', 720, 674);
            }

            function popupCenter(url, title, w, h) {
                var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
                var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

                var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
                var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

                var left = ((width / 2) - (w / 2)) + dualScreenLeft;
                var top = ((height / 2) - (h / 2)) + dualScreenTop;
                var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

                if (window.focus) {
                    newWindow.focus();
                }
            }
        </script>
    </x-slot>

</x-dashboard>
