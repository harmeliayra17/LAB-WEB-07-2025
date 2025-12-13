@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item">
        <a href="{{ route('categories.index') }}">🏷️ Kategori</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item active">
        <span>Detail</span>
    </div>
@endsection

@section('topbar-actions')
    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
        <span>✏️</span>
        <span>Edit Kategori</span>
    </a>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">🏷️</span>
                {{ $category->name }}
            </h1>
        </div>
        <p class="page-subtitle">Detail lengkap kategori dan produk terkait</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📋</span>
                Informasi Kategori
            </h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Nama Kategori</label>
                    <p style="font-size: 18px; font-weight: 700; color: var(--text-primary);">{{ $category->name }}</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Deskripsi</label>
                    <p style="font-size: 15px; color: var(--text-primary); line-height: 1.6;">
                        {{ $category->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📦</span>
                Daftar Produk dalam Kategori Ini
                <span class="badge badge-info" style="margin-left: 8px;">{{ $category->products->count() }} produk</span>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Berat (kg)</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($category->products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="font-weight: 600;">{{ $product->name }}</td>
                                <td style="color: var(--success); font-weight: 600;">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->detail->weight ?? 'N/A' }}</td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <a href="{{ route('products.show', $product) }}" class="btn-icon view" title="Detail Produk">
                                            👁️
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn-icon edit" title="Edit Produk">
                                            ✏️
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📦</div>
                                        <h3 class="empty-state-title">Belum ada produk</h3>
                                        <p class="empty-state-description">Kategori ini belum memiliki produk</p>
                                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                                            <span>+</span>
                                            <span>Tambah Produk Baru</span>
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