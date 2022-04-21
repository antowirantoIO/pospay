<x-dashboard title="Input data supplier">
    <div class="section-header">
        <h1>Input Data Supplier</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></div>
            <div class="breadcrumb-item">Buat Data Supplier</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Management Data Supplier</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('supplier.store') }}" method="POST" novalidate>
                            @csrf
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Nama Supplier</label>
                                    <input type="text" class="form-control" name="nama"
                                        placeholder="Masukkan Nama Supplier" required>
                                    @error('nama')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat" rows="20" required></textarea>
                                    @error('alamat')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>No Telepon</label>
                                    <input type="text" class="form-control" name="telepon"
                                        placeholder="Masukkan No Telepon" required>
                                    @error('telepon')
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
