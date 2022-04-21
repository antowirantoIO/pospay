<x-dashboard title="Manage data Product">
    <x-slot name="css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/datatables.net-select-bs4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs/themes/prism.css">
        <style>
            .tampil-bayar {
                font-size: 5em;
                text-align: center;
                height: 100px;
            }

            .tampil-terbilang {
                padding: 10px;
                background: #f0f0f0;
            }

            .table-pembelian tbody tr:last-child {
                display: none;
            }

            @media(max-width: 768px) {
                .tampil-bayar {
                    font-size: 3em;
                    height: 70px;
                    padding-top: 5px;
                }
            }

        </style>
    </x-slot>
    <div class="section-header">
        <h1>Transaksi Pembelian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Transaksi pembelian</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Transaksi pembelian</h4>
                </div>
                <div class="card-body">
                    <div>
                        <form id="form_product">
                            @csrf
                            <div class="form-group row">
                                <label for="kode_produk" class="col-lg-2">Kode Produk</label>
                                <div class="col-lg-5">
                                    <div class="input-group">
                                        <input type="hidden" name="id_penjualan" id="id_penjualan"
                                            value="{{ $id_penjualan }}">
                                        <input type="hidden" name="id_product" id="id_product">
                                        <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                        <span class="input-group-btn">
                                            <button onclick="tampilProduct()" class="btn btn-info" type="button">
                                                <i class="fa fa-arrow-right">
                                                </i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-pembelian table-responsive" id="table-penjualan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th width="15%">Jumlah</th>
                                    <th>Diskon</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="tampil-bayar bg-primary text-white">Rp. 300.000</div>
                            <div class="tampil-terbilang">Rp. Tiga Ratus Ribu Rupiah</div>
                        </div>
                        <div class="col-lg-4">
                            <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                                @csrf
                                <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">

                                <div class="form-group row">
                                    <label for="totalrp" class="col-lg-4 control-label">Total</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="totalrp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customer" class="col-lg-4 control-label">Customer</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="id_customer" id="id_customer"
                                            value="{{ Auth::user()->role('admin') ? ($customerActive->id_customer ?? '') : Auth::user()->id_customer }}"
                                            class="form-control">
                                        @role('admin')
                                            <span class="input-group-btn">
                                                <button onclick="tampilCustomer()" class="btn btn-info" type="button">
                                                    <i class="fa fa-arrow-right">
                                                    </i>
                                                </button>
                                            </span>
                                        @endrole
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diterima" class="col-lg-4 control-label">Diterima</label>
                                    <div class="col-lg-8">
                                        <input type="number" name="diterima" value="{{ $penjualan->diterima ?? 0 }}" id="diterima"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diskon" class="col-lg-4 control-label">Diskon</label>
                                    <div class="col-lg-8">
                                        <input type="number" name="diskon" value="{{ $customerActive->diskon ?? 0 }}" id="diskon" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bayar" class="col-lg-4 control-label">Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="bayarrp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kembali" class="col-lg-4 control-label">Kembali</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="kembali" value="0" class="form-control" readonly>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="modal">
        <div class="modal fade" id="modal-product" tabindex="-5" role="dialog" aria-labelledby="modal-product">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cari product</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-product">
                                <thead>
                                    <th>Kode Product</th>
                                    <th>nama product</th>
                                    <th>Harga Beli</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->kode_barang }}</td>
                                            <td>{{ $product->nama_barang }}</td>
                                            <td>{{ $product->harga_beli }}</td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary"
                                                        onclick="pilihProduct('{{ $product->id }}', '{{ $product->kode_barang }}')">
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
        @role('admin')
            <div class="modal fade" id="modal-customer" tabindex="-5" role="dialog" aria-labelledby="modal-product">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cari Customer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-customer">
                                    <thead>
                                        <th>Kode Customer</th>
                                        <th>Nama Customer</th>
                                        <td>Email</td>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->id_customer }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>
                                                    <div>
                                                        <a href="#" class="btn btn-primary"
                                                            onclick="pilihCustomer('{{ $customer->id_customer }}')">
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
        @endrole
    </x-slot>

    <x-slot name="js">
        <script src="https://cdn.jsdelivr.net/npm/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/prismjs/prism.js"></script>

        <script>
            let table_trans = $("#table-penjualan").DataTable({
                responsive: true,
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('transaksi.show', $id_penjualan) }}',
                    "dataSrc": '',
                },

                columns: [{
                        data: "",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "products.[0].kode_barang",
                    },
                    {
                        data: "products.[0].nama_barang"
                    },
                    {
                        data: "harga_jual"
                    },
                    {
                        data: "jumlah",
                        render: function(data, type, row, meta) {
                            return `
                                <input type="number" class="form-control input-sm" id="quantity" data-id="${row.id}" value="${data}">
                            `;
                        }
                    },
                    {
                        data: "diskon",
                    },
                    {
                        data: "subtotal"
                    },
                    {
                        data: "id",
                        render: function(data, type, row, meta) {
                            return `
                                <a href="#" class="btn btn-danger" onclick="deleteData('${data}')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            `;
                        }
                    }
                ],
                dom: "Brt",
            }).on('draw.dt', function() {
                loadForm($('#diskon').val());
                setTimeout(() => {
                    $('#diterima').trigger('keyup');
                }, 300);
            });

            $("#table-product").DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [0, 2, 3]
                }]
            });

            $("#table-customer").DataTable({
                autoWidth: false,
                "columnDefs": [{
                    "sortable": false,
                    "targets": [0, 1]
                }]
            });

            $(document).on('keyup', '#quantity', function() {
                let id = $(this).data('id');
                let quantity = parseInt($(this).val());

                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                if (quantity > 1000) {
                    swal('Oops!', 'Jumlah tidak boleh lebih dari 1000', 'error');
                    $(this).val('1');
                }

                $.ajax({
                    url: '{{ route('transaksi.update', ':id') }}'.replace(':id', id),
                    type: 'PATCH',
                    data: {
                        jumlah: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        table_trans.ajax.reload();
                        loadForm($('#diskon').val());
                    }
                });
            });

            $(document).on('keyup', '#diskon', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($(this).val());
            });

            $(document).on('keyup', '#diterima', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($('#diskon').val(), $(this).val());
            }).focus(function() {
                $(this).select();
            });


            function pilihProduct(id, kode) {
                $('#id_product').val(id);
                $('#kode_produk').val(kode);

                $('#modal-product').modal('hide');
                tambahProduct();
            }

            function pilihCustomer(kode) {
                $('#id_customer').val(kode);
                $('#diterima').val(0).focus().select();
                $('#modal-customer').modal('hide');
            }

            function tambahProduct() {
                $.post('{{ route('transaksi.store') }}', $('#form_product').serialize())
                    .done(response => {
                        $('#kode_produk').focus();
                        table_trans.ajax.reload();
                        loadForm($('#diskon').val());
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }

            function tampilProduct() {
                $('#modal-product').modal('show');
            }

            function tampilCustomer() {
                $('#modal-customer').modal('show');
            }

            // create function delete ajax datatable
            function deleteData(id) {
                swal({
                        title: "Apakah anda yakin?",
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: '{{ route('transaksi.delete', ':id') }}'.replace(':id', id),
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    table_trans
                                        .ajax
                                        .reload();
                                    loadForm($('#diskon').val());
                                }
                            });
                        }
                    });
            }

            function loadForm(diskon = 0, diterima = 0) {
                $('#total').val($('.total').text());
                $('#total_item').val($('.total_item').text());

                $.get(`{{ url('/dashboard/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
                    .done(response => {
                        $('#totalrp').val('Rp. ' + response.totalrp);
                        $('#bayarrp').val('Rp. ' + response.bayarrp);
                        $('#bayar').val(response.bayar);
                        $('.tampil-bayar').text('Bayar : Rp. ' + response.bayarrp);
                        $('.tampil-terbilang').text(response.terbilang);

                        $('#kembali').val('Rp. ' + response.kembalirp);
                        if ($('#diterima').val() != 0) {
                            $('.tampil-bayar').text('Kembalian : Rp. ' + response.kembalirp);
                            $('.tampil-terbilang').text(response.kembali_terbilang);
                        }
                    })
                    .fail(errors => {
                        alert('Tidak dapat menampilkan data');
                        return;
                    })

            }
        </script>
    </x-slot>

</x-dashboard>
