<x-dashboard title="Dashboard">
    <x-slot name="css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jqvmap/dist/jqvmap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel/dist/assets/owl.theme.default.min.css">
    </x-slot>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Order Statistics -
                        <div class="dropdown d-inline">
                            <a class="font-weight-600" href="#" id="orders-month">{{ date('M') }}</a>
                        </div>
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $pembelianCount }}</div>
                            <div class="card-stats-item-label">Pembelian</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $penjualanCount }}</div>
                            <div class="card-stats-item-label">Penjualan</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $userCount }}</div>
                            <div class="card-stats-item-label">Customer</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Estimasi Laba Bulan</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ $estimasiLabaBulan }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penghasilan Total</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ $estimasiLaba }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan</h4>
                    </div>
                    <div class="card-body">
                        {{ $penjualanAll }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Budget vs Sales</h4>
                </div>
                <div class="card-body chart-laporan">
                    <canvas id="chartLaporan" height="158"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card gradient-bottom">
                <div class="card-header">
                    <h4>Barang Low Stok</h4>
                </div>
                <div class="card-body" id="top-5-scroll">
                    <ul class="list-unstyled list-unstyled-border">
                        @if ($barangLowStok->count() >= 0)
                            <p class="text-center">
                                <strong>{{ $barangLowStok->count() }}</strong>
                                <span>Barang</span>
                            </p>
                        @endif
                        @foreach ($barangLowStok as $barang)
                            <li class="media">
                                <div class="media-body">
                                    <div class="float-right">
                                        <div class="font-weight-600 text-small">Stok <span
                                                class="text-warning">{{ $barang->stok }}</span></div>
                                    </div>
                                    <div class="media-title">{{ $barang->nama_barang }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="js">
        <script src="https://cdn.jsdelivr.net/npm/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/owl.carousel/dist/owl.carousel.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chocolat/dist/js/jquery.chocolat.min.js"></script>
        <script src="{{ asset('assets/js/page/index.js') }}"></script>

        <script>
            var ctx = document.getElementById("chartLaporan").getContext('2d');
            var range = {{ $estimasiLaba }} > 50000 ? 10000 : 50000;
            var chartLaporan = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                        "October", "November", "December"
                    ],
                    datasets: [{
                            label: 'Pembelian',
                            data: {{ json_encode($dataChartLaporan['dataPembelian']) }},
                            borderWidth: 2,
                            backgroundColor: 'rgba(63,82,227,.8)',
                            borderWidth: 0,
                            borderColor: 'transparent',
                            pointBorderWidth: 0,
                            pointRadius: 3.5,
                            pointBackgroundColor: 'transparent',
                            pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                        },
                        {
                            label: 'Penjualan',
                            data: {{ json_encode($dataChartLaporan['dataPenjualan']) }},
                            borderWidth: 2,
                            backgroundColor: 'rgba(254,86,83,.7)',
                            borderWidth: 0,
                            borderColor: 'transparent',
                            pointBorderWidth: 0,
                            pointRadius: 3.5,
                            pointBackgroundColor: 'transparent',
                            pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
                        }
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                // display: false,
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: range,
                                callback: function(value, index, values) {
                                    return 'Rp.' + value;
                                }
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false,
                                tickMarkLength: 15,
                            }
                        }]
                    },
                }
            });
        </script>
    </x-slot>
</x-dashboard>
