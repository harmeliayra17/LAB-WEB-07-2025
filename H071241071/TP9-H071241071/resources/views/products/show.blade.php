@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Detail Produk: {{ $product->name }}</h2>
    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning shadow-sm">
        <i class="bi bi-pencil-square me-1"></i> Edit Produk
    </a>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-lg border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-tag me-1"></i> Informasi Dasar & Harga</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Nama Produk:</span>
                    <span class="text-end">{{ $product->name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Harga:</span>
                    <span class="text-end fs-5 text-success fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Kategori:</span>
                    <span class="badge text-bg-primary text-end">{{ $product->category?->name ?? 'Tidak Berkategori' }}</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-lg">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-ruler me-1"></i> Spesifikasi Fisik</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <span class="fw-semibold d-block mb-1">Deskripsi Detail:</span>
                    <p class="mb-0 text-muted">{{ $product->detail?->description ?? 'Tidak ada deskripsi detail.' }}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Berat:</span>
                    <span class="text-end">{{ $product->detail?->weight }} kg</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Ukuran:</span>
                    <span class="text-end">{{ $product->detail?->size ?? '-' }}</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-box-fill me-1"></i> Stok di Gudang</h5>
            </div>
            <div class="card-body">
                @if($product->warehouses->isEmpty())
                    <div class="alert alert-warning mb-0">Produk ini belum memiliki stok di gudang manapun.</div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($product->warehouses as $wh)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">{{ $wh->name }}</span>
                                <span class="badge text-bg-success fs-6">{{ number_format($wh->pivot->quantity, 0, ',', '.') }} unit</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<a href="{{ route('products.index') }}" class="btn btn-secondary mt-2">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Produk
</a>
@endsection