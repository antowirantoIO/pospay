{{-- {{ dd($data['pembelian']) }} --}}
<x-dashboard title="Manage data Laporan">
    <x-slot name="css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/datatables.net-select-bs4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs/themes/prism.css">

    </x-slot>
    <div class="section-header">
        <h1>Kelola Data Laporan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Data Laporan</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Data Laporan</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form id="form-date" action="{{ route('laporan.refresh') }}">
                        @csrf
                        <div class="row d-flex justify-items-center">
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="text" value="{{ request('tanggal_mulai') }}" name="tanggal_mulai"
                                        class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="text" value="{{ request('tanggal_akhir') }}" name="tanggal_akhir"
                                        class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i>
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-laporan">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <th>Tanggal</th>
                                    <th>Total Penjualan</th>
                                    <th>Total Pembelian</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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

        <script>
            // var data = $.ajax({
            //     url: "{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}",
            //     dataType: 'json',
            //     async: false
            // }).responseJSON;

            // console.log(data);
            $('#table-laporan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}",
                    dataType: 'json',
                    dataSrc: "",
                    type: 'GET',
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'total_penjualan'
                    },
                    {
                        data: 'total_pembelian'
                    },
                    {
                        data: 'pendapatan'
                    }
                ],
                dom: 'Bfr',
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });
        </script>
    </x-slot>

</x-dashboard>
