<div>
    <div class="main-sidebar">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="index.html">St</a>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class="nav-item dropdown {{ request()->segment(2) == '' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link"><i
                            class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
                @role('admin')
                    <li class="menu-header">Management Data</li>
                    <li class="nav-item {{ request()->segment(2) == 'supplier' ? 'active' : '' }}">
                        <a href="{{ route('supplier.index') }}" class="nav-link"><i class="fas fa-archive"></i>
                            <span>Data Suplayer</span></a>
                    </li>
                    <li class="nav-item {{ request()->segment(2) == 'product' ? 'active' : '' }}">
                        <a href="{{ route('product.index') }}" class="nav-link"><i class="fas fa-th-large"></i>
                            <span>Data Barang</span></a>
                    </li>
                    <li class="nav-item {{ request()->segment(2) == 'pembelian' ? 'active' : '' }}">
                        <a href="{{ route('pembelian.index') }}" class="nav-link"><i class="fas fa-archive"></i>
                            <span>Data Pembelian</span></a>
                    </li>
                @endrole
                <li class="nav-item {{ request()->segment(2) == '' ? 'penjualan' : '' }}">
                    <a href="{{ route('penjualan.index') }}" class="nav-link"><i
                            class="fas fa-shopping-bag"></i>
                        <span>Data Transaksi</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="menu-header">Transaksi</li>
                <li class="nav-item {{ request()->segment(2) == 'transaksi' ? 'active' : '' }}">
                    <a href="{{ route('transaksi.new') }}" class="nav-link"><i class="fas fa-archive"></i>
                        <span>Transaksi Baru</span></a>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'transaksi' ? 'active' : '' }}">
                    <a href="{{ route('transaksi.index') }}" class="nav-link"><i
                            class="fas fa-shopping-bag"></i>
                        <span>Transaksi Sebelumnya</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="menu-header">Laporan</li>
                <li class="nav-item {{ request()->segment(2) == 'laporan' ? 'active' : '' }}">
                    <a href="{{ route('laporan.index') }}" class="nav-link"><i class="fas fa-archive"></i>
                        <span>laporan</span></a>
                </li>
            </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                    <i class="fas fa-rocket"></i> Documentation
                </a>
            </div>
        </aside>
    </div>
</div>
