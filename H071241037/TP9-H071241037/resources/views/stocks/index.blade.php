@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')
    <h2>Manajemen Stok</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Transfer Stok</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('stocks.transfer') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="warehouse_id_transfer" class="form-label">Gudang <span class="text-danger">*</span></label>
                            <select class="form-select @error('warehouse_id') is-invalid @enderror" id="warehouse_id_transfer" name="warehouse_id" required>
                                <option value="">Pilih Gudang...</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warehouse_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk <span class="text-danger">*</span></label>
                            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                                <option value="">Pilih Produk...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Kuantitas <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                            <div class="form-text">Gunakan nilai positif (misal: 10) untuk menambah stok, dan nilai negatif (misal: -10) untuk mengurangi stok.</div>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Proses Transfer</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Stok di Gudang</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('stocks.index') }}" class="mb-3">
                        <div class="input-group">
                            <select class="form-select" name="warehouse_id" onchange="this.form.submit()">
                                <option value="">Tampilkan Semua Gudang</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ $selectedWarehouseId == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-secondary" type="submit">Filter</button>
                        </div>
                    </form>

                    @forelse ($stockData as $warehouse)
                        <div class="mb-4">
                            <h5>{{ $warehouse->name }} <span class="text-muted fs-6">({{ $warehouse->location ?? 'Lokasi tidak ada' }})</span></h5>
                            <table class="table table-bordered table-sm table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th width="100px">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($warehouse->products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->pivot->quantity }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada produk di gudang ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <div class="text-center">
                            <p>Tidak ada data stok untuk ditampilkan. Silakan pilih filter atau lakukan transfer stok.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection