<x-dashboard title="Manage data Product">
    <x-slot name="css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/datatables.net-select-bs4/css/select.bootstrap4.min.css">
    </x-slot>
    <div class="section-header">
        <h1>Kelola Data Barang</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Data Barang</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Data Barang</h4>
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Tambah Data Barang</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-2">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merk</th>
                                    <th>Stok</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Diskon</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    class="custom-control-input" id="checkbox-1">
                                                <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{ $product->kode_barang }}</td>
                                        <td>{{ $product->nama_barang }}</td>
                                        <td>{{ $product->merek }}</td>
                                        <td>{{ $product->stok }}</td>
                                        <td>{{ $product->harga_beli }}</td>
                                        <td>{{ $product->harga_jual }}</td>
                                        <td>{{ $product->diskon }} %</td>
                                        <td>
                                            @if ($product->stok == 0)
                                                <div class="badge badge-danger">Out of Stock</div>
                                            @elseif($product->stok < 10)
                                                <div class="badge badge-warning">Low Stock</div>
                                            @else
                                                <div class="badge badge-primary">In Stock</div>
                                            @endif
                                        </td>
                                        <td class="items-center">
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="
                                                        {{ route('product.edit', $product->kode_barang) }}"><i
                                                            class="fas fa-edit text-warning pr-2"></i> Edit </a>
                                                    <a class="dropdown-item" id="button_delete" href="#"><i
                                                            class="fas fa-trash text-danger pr-2"></i> Delete </a>
                                                    <form id="form_delete"
                                                        action="{{ route('product.delete', $product->kode_barang) }}"
                                                        method="POST">@csrf @method('DELETE')</form>
                                                </div>
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

    <x-slot name="js">
        <script src="https://cdn.jsdelivr.net/npm/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
        <script src="/assets/js/page/modules-datatables.js"></script>
        <script>
            $("#button_delete").click(function() {
                swal({
                        title: 'Are you sure?',
                        text: 'Once deleted, you will not be able to recover this product data!',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_delete").submit();
                        } else {
                            swal('Your product data file is safe!', {
                                icon: 'error',
                            });
                        }
                    });
            });
        </script>
    </x-slot>
</x-dashboard>
