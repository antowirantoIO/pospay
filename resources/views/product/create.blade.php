<x-dashboard title="Manage data Product">
    <div class="section-header">
        <h1>Input Data Barang</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Barang</a></div>
            <div class="breadcrumb-item">Buat Data Barang</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Management Data Barang</h4>
                    </div>
                    {{-- /**
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Merk</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                    **/ --}}
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST" novalidate>
                            @csrf
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Kode Barang</label>
                                    <input type="text" class="form-control" name="kode_barang"
                                        placeholder="Masukkan Kode Barang" required>
                                    @error('kode_barang')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang"
                                        placeholder="Masukkan Nama Barang" required>
                                    @error('nama_barang')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Merk</label>
                                    <input type="text" class="form-control" name="merek" placeholder="Masukkan Merk">
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" class="form-control" name="stok" placeholder="Masukkan Stok"
                                        required>
                                    @error('stok')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga Beli</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="number" class="form-control currency" name="harga_beli"
                                            placeholder="Masukkan harga Beli" required>

                                    </div>
                                    @error('harga_beli')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="number" class="form-control currency" name="harga_jual"
                                            placeholder="Masukkan Harag Jual" required>

                                    </div>
                                    @error('harga_jual')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Diskon</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="diskon"
                                            placeholder="Masukkan Diskon" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                %
                                            </div>
                                        </div>

                                    </div>
                                    @error('diskon')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-dashboard>
