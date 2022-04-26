<x-dashboard title="Manage data Pembelian">
    <x-slot name="css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/datatables.net-select-bs4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs/themes/prism.css">
    </x-slot>
    <div class="section-header">
        <h1>Kelola Data Pembelian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Data Pembelian</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Data Pembelian</h4>
                    <div>
                        <button onclick="openModalSupplier()" class="btn btn-primary">Buat transaksi baru</button>
                        @empty(!session('id_pembelian'))
                            <a href="{{ route('pembelian_detail.index') }}" class="btn btn-info">Lihat transaksi</a>
                        @endempty
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-product">
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
                                    <th>Supplier</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Diskon</th>
                                    <th>Total Bayar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelian as $item)
                                    <tr>
                                        <td class="text-center">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    class="custom-control-input" id="checkbox-1">
                                                <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        @php
                                            $supplier = App\Models\Supplier::where('id', $item->id_supplier)->first();
                                        @endphp
                                        <td>{{ tanggal_indonesia($item->created_at) }}</td>
                                        <td>{{ $supplier->nama }}</td>
                                        <td>{{ $item->total_item }}</td>
                                        <td>Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $item->diskon }} %</td>
                                        <td>Rp. {{ number_format($item->bayar, 0, ',', '.') }}</td>
                                        <td class="items-center">
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"
                                                        onclick="showDetails('{{ route('pembelian.show', $item->id) }}')"
                                                        href="
                                                        #"><i class="fas fa-eye text-info pr-2"></i> Show </a>
                                                    <a class="dropdown-item"
                                                        onclick="deleteDetails('{{ route('pembelian.delete', $item->id) }}')"
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
        <div class="modal fade" id="modal-supplier" tabindex="-5" role="dialog" aria-labelledby="modal-supplier">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Supplier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-supplier">
                                <thead>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th><i class="fa fa-cog"></i></th>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $key => $item)
                                        <tr>
                                            <td width="5%">{{ $key + 1 }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->telepon }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('pembelian.create', $item->id) }}"
                                                        class="btn btn-primary">
                                                        <i class="fa fa-check-circle"></i>
                                                        Pilih
                                                    </a>
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

        <div class="modal fade" id="modal-detail" tabindex="-5" role="dialog" aria-labelledby="modal-detail">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Barang pembelian</h4>
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
            $("#table-product").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [0, 2, 3]
                }]
            });

            $("#table-supplier").dataTable({
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
                                item.harga_beli,
                                item.jumlah,
                                item.subtotal
                            ]).draw();
                        });

                        $('#modal-detail').modal('show');
                    }
                });
                $('#modal-detail').modal('show');
            }

            // $("#table-detail").DataTable({
            //     responsive: true,
            //     processing: true,
            //     autoWidth: false,
            //     ajax: {
            //         url: '{{ route('pembelian.show', 10) }}',
            //         dataSrc: ''
            //     },
            //     columns: [{
            //             data: '',
            //             render: function(data, type, row, meta) {
            //                 return meta.row + meta.settings._iDisplayStart + 1;
            //             }
            //         },
            //         {
            //             data: 'kode_barang'
            //         },
            //         {
            //             data: 'nama_barang'
            //         },
            //         {
            //             data: 'harga_beli'
            //         },
            //         {
            //             data: 'jumlah'
            //         },
            //         {
            //             data: 'subtotal'
            //         }
            //     ]
            // });

            function openModalSupplier() {
                $('#modal-supplier').modal('show');
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
        </script>
    </x-slot>

</x-dashboard>
