@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item active">
        <span>📦 Produk</span>
    </div>
@endsection

@section('topbar-actions')
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <span>+</span>
        <span>Tambah Produk</span>
    </a>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">📦</span>
                Daftar Produk
            </h1>
        </div>
        <p class="page-subtitle">Kelola semua produk dalam sistem</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Berat (kg)</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
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
                                <td style="color: var(--success); font-weight: 600;">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->detail->weight ?? 'N/A' }}</td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <a href="{{ route('products.show', $product) }}" class="btn-icon view" title="Detail">
                                            👁️
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn-icon edit" title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Semua data terkait (pergerakan stok, dll.) akan ikut terhapus. Tindakan ini tidak dapat dibatalkan!');">
                                            
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon delete" title="Hapus">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📦</div>
                                        <h3 class="empty-state-title">Belum ada produk</h3>
                                        <p class="empty-state-description">Mulai tambahkan produk pertama Anda</p>
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