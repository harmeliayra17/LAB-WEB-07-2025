@extends('layouts.app')

@section('title', 'Detail Gudang')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item">
        <a href="{{ route('warehouses.index') }}">🏭 Gudang</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item active">
        <span>Detail</span>
    </div>
@endsection

@section('topbar-actions')
    <a href="{{ route('stocks.index', ['warehouse_id' => $warehouse->id]) }}" class="btn btn-secondary">
        <span>📊</span>
        <span>Lihat Stok</span>
    </a>
    <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning">
        <span>✏️</span>
        <span>Edit Gudang</span>
    </a>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">🏭</span>
                {{ $warehouse->name }}
            </h1>
        </div>
        <p class="page-subtitle">Detail lengkap informasi gudang dan stok produk</p>
    </div>

    <!-- Warehouse Info -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📋</span>
                Informasi Gudang
            </h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Nama Gudang</label>
                    <p style="font-size: 18px; font-weight: 700; color: var(--text-primary);">{{ $warehouse->name }}</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Lokasi</label>
                    <p style="font-size: 15px; color: var(--text-primary); line-height: 1.6;">
                        {{ $warehouse->location ?? 'Lokasi tidak tersedia.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Products in Warehouse -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📦</span>
                Stok Produk di Gudang Ini
                <span class="badge badge-info" style="margin-left: 8px;">{{ $warehouse->products->count() }} produk</span>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Jumlah Stok</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($warehouse->products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="font-weight: 600;">{{ $product->name }}</td>
                                <td>
                                    @if($product->category)
                                        <span class="badge badge-info">{{ $product->category->name }}</span>
                                    @else
                                        <span class="badge" style="background: #e2e8f0; color: #64748b;">Tanpa Kategori</span>
                                    @endif
                                </td>
                                <td style="font-weight: 600; color: var(--primary);">{{ $product->pivot->quantity }} unit</td>
                                <td>
                                    @if($product->pivot->quantity > 50)
                                        <span class="badge badge-success">Stok Banyak</span>
                                    @elseif($product->pivot->quantity > 10)
                                        <span class="badge badge-warning">Stok Sedang</span>
                                    @elseif($product->pivot->quantity > 0)
                                        <span class="badge badge-danger">Stok Rendah</span>
                                    @else
                                        <span class="badge" style="background: #f1f5f9; color: #64748b;">Habis</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <a href="{{ route('products.show', $product) }}" class="btn-icon view" title="Detail Produk">
                                            👁️
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📦</div>
                                        <h3 class="empty-state-title">Belum ada stok</h3>
                                        <p class="empty-state-description">Gudang ini belum memiliki stok produk</p>
                                        <a href="{{ route('stocks.index') }}" class="btn btn-primary">
                                            <span>📊</span>
                                            <span>Kelola Stok</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection