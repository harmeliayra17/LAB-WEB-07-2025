@extends('layouts.app')
@section('content')

<h2 class="text-primary mb-4 fw-bold"><i class="bi bi-arrow-left-right me-2"></i> Transfer / Adjustment Stok</h2>

<div class="card shadow-lg p-4">
    <div class="card-body">
        <form action="{{ route('stocks.transfer') }}" method="POST">
            @csrf
            
            <h5 class="mb-4 text-secondary">Pilih Lokasi & Produk</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="warehouse_id" class="form-label fw-semibold">Gudang Tujuan/Sumber <span class="text-danger">*</span></label>
                    <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                        <option value="">Pilih Gudang</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="product_id" class="form-label fw-semibold">Produk <span class="text-danger">*</span></label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <hr class="mt-4 mb-4">
            
            <h5 class="mb-3 text-secondary">Jumlah Stok</h5>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4">
                        <label for="quantity" class="form-label fw-semibold">Jumlah Stok (+/-) <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="quantity" class="form-control form-control-lg" placeholder="Contoh: 10 (tambah) atau -5 (kurangi)" required>
                        <div class="form-text mt-2">
                            Gunakan angka **positif** (misal: `10`) untuk **menambah stok**.
                            Gunakan angka **negatif** (misal: `-5`) untuk **mengurangi stok** (penyesuaian/pengeluaran).
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-start gap-2 pt-3">
                <button type="submit" class="btn btn-primary fw-bold shadow-sm btn-lg">
                    <i class="bi bi-check-circle-fill me-1"></i> Proses Transfer / Adjustment
                </button>
                <a href="{{ route('stocks.index') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection