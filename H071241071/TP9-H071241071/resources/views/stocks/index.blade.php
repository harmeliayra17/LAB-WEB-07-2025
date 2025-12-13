@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Inventaris Stok Keseluruhan</h2>
    <a href="{{ route('stocks.transfer.form') }}" class="btn btn-success fw-bold shadow-lg">
        <i class="bi bi-arrow-left-right me-1"></i> Transfer / Adjustment Stok
    </a>
</div>

<div class="card shadow-sm mb-4 p-3">
    <h5 class="card-title mb-3 text-secondary"><i class="bi bi-funnel me-1"></i> Filter Data</h5>
    <form method="GET" class="row align-items-center">
        <div class="col-md-4">
            <label for="warehouse_filter" class="form-label visually-hidden">Pilih Gudang</label>
            <select name="warehouse_id" id="warehouse_filter" class="form-select" onchange="this.form.submit()">
                <option value="">-- Tampilkan Semua Gudang --</option>
                @foreach($warehouses as $w)
                    <option value="{{ $w->id }}" {{ $warehouseId == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="bg-info text-white">
                <tr>
                    <th style="width: 40%;">Produk</th>
                    <th style="width: 40%;">Gudang</th>
                    <th class="text-center" style="width: 20%;">Stok Saat Ini</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    @forelse($product->warehouses as $wh)
                        <tr>
                            <td class="fw-semibold">{{ $product->name }}</td>
                            <td><span class="badge text-bg-primary">{{ $wh->name }}</span></td>
                            <td class="text-center fs-5 fw-bold text-success">{{ $wh->pivot->quantity }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="fw-semibold">{{ $product->name }}</td>
                            <td colspan="2" class="text-center text-muted fst-italic">Tidak ada stok tercatat di gudang ini.</td>
                        </tr>
                    @endforelse
                @empty
                    <tr><td colspan="3" class="text-center text-danger py-4 fs-5">
                        <i class="bi bi-x-octagon me-2"></i> Belum ada data produk atau stok yang tercatat.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection