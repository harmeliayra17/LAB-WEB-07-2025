@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item active">
        <span>🏷️ Kategori</span>
    </div>
@endsection

@section('topbar-actions')
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <span>+</span>
        <span>Tambah Kategori</span>
    </a>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">🏷️</span>
                Daftar Kategori Produk
            </h1>
        </div>
        <p class="page-subtitle">Kelola semua kategori produk dalam sistem</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Produk</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="font-weight: 600;">{{ $category->name }}</td>
                                <td style="color: var(--text-secondary);">{{ $category->description ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $category->products->count() }} produk</span>
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <a href="{{ route('categories.show', $category) }}" class="btn-icon view" title="Detail">
                                            👁️
                                        </a>
                                        <a href="{{ route('categories.edit', $category) }}" class="btn-icon edit" title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua data terkait (pergerakan stok, dll.) akan ikut terhapus. Tindakan ini tidak dapat dibatalkan!');">
                                            
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
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">🏷️</div>
                                        <h3 class="empty-state-title">Belum ada kategori</h3>
                                        <p class="empty-state-description">Mulai dengan menambahkan kategori pertama Anda</p>
                                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                            <span>+</span>
                                            <span>Tambah Kategori</span>
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