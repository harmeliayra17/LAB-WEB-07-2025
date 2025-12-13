@extends('layouts.app')

@section('title', 'Detail Produk')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item">
        <a href="{{ route('products.index') }}">📦 Produk</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item active">
        <span>Detail</span>
    </div>
@endsection

@section('topbar-actions')
    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
        <span>✏️</span>
        <span>Edit Produk</span>
    </a>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">🔍</span>
                {{ $product->name }}
            </h1>
        </div>
        <p class="page-subtitle">Detail lengkap informasi produk</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📋</span>
                Informasi Utama
            </h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Nama Produk</label>
                    <p style="font-size: 16px; font-weight: 600; color: var(--text-primary);">{{ $product->name }}</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Harga</label>
                    <p style="font-size: 16px; font-weight: 600; color: var(--success);">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Kategori</label>
                    @if($product->category)
                        <span class="badge badge-info">{{ $product->category->name }}</span>
                    @else
                        <span class="badge" style="background: #e2e8f0; color: #64748b;">Tanpa Kategori</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📝</span>
                Detail Spesifikasi
            </h3>
        </div>
        <div class="card-body">
            @php
                $detail = $product->detail;
            @endphp
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 20px;">
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Berat</label>
                    <p style="font-size: 16px; font-weight: 600; color: var(--text-primary);">{{ $detail->weight ?? 'N/A' }} kg</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Ukuran</label>
                    <p style="font-size: 16px; font-weight: 600; color: var(--text-primary);">{{ $detail->size ?? 'N/A' }}</p>
                </div>
            </div>

            <div>
                <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Deskripsi</label>
                <p style="font-size: 15px; color: var(--text-primary); line-height: 1.6;">
                    {{ $detail->description ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>
        </div>
    </div>

    
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📊</span>
                Stok di Gudang
            </h3>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Gudang</th>
                            <th>Jumlah Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($product->warehouses as $warehouse)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="font-weight: 600;">{{ $warehouse->name }}</td>
                                <td style="font-weight: 600; color: var(--primary);">{{ $warehouse->pivot->quantity }} unit</td>
                                <td>
                                    @if($warehouse->pivot->quantity > 50)
                                        <span class="badge badge-success">Stok Banyak</span>
                                    @elseif($warehouse->pivot->quantity > 10)
                                        <span class="badge badge-warning">Stok Sedang</span>
                                    @elseif($warehouse->pivot->quantity > 0)
                                        <span class="badge badge-danger">Stok Rendah</span>
                                    @else
                                        <span class="badge" style="background: #f1f5f9; color: #64748b;">Habis</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📦</div>
                                        <h3 class="empty-state-title">Belum ada stok</h3>
                                        <p class="empty-state-description">Produk ini belum memiliki stok di gudang manapun</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📜</span>
                Riwayat Pergerakan Stok
            </h3>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal & Waktu</th>
                            <th>Gudang</th>
                            <th>Perubahan</th>
                            <th>Stok Akhir</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($product->movements->sortByDesc('created_at') as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('d/m/Y H:i:s') }}</td>
                                <td style="font-weight: 600;">{{ $movement->warehouse->name ?? 'N/A' }}</td>
                                <td>
                                    @if($movement->value > 0)
                                        <span style="color: var(--success); font-weight: 700;">+{{ $movement->value }}</span>
                                    @else
                                        <span style="color: var(--danger); font-weight: 700;">{{ $movement->value }}</span>
                                    @endif
                                </td>
                                <td style="font-weight: 600;">{{ $movement->stock_after }} unit</td>
                                <td>{{ $movement->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📜</div>
                                        <h3 class="empty-state-title">Belum ada riwayat</h3>
                                        <p class="empty-state-description">Belum ada pergerakan stok untuk produk ini</p>
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