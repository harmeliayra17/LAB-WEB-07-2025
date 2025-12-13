@extends('layouts.app')

@section('title', 'Daftar Gudang')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item active">
        <span>🏭 Gudang</span>
    </div>
@endsection

@section('topbar-actions')
    <a href="{{ route('stocks.index') }}" class="btn btn-secondary">
        <span>📊</span>
        <span>Lihat Stok</span>
    </a>
    <a href="{{ route('warehouses.create') }}" class="btn btn-primary">
        <span>+</span>
        <span>Tambah Gudang</span>
    </a>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">🏭</span>
                Daftar Gudang
            </h1>
        </div>
        <p class="page-subtitle">Kelola semua lokasi gudang penyimpanan produk</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Gudang</th>
                            <th>Lokasi</th>
                            <th>Total Produk</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($warehouses as $warehouse)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="font-weight: 600;">{{ $warehouse->name }}</td>
                                <td style="color: var(--text-secondary);">{{ $warehouse->location ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $warehouse->products->count() }} produk</span>
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <a href="{{ route('stocks.index', ['warehouse_id' => $warehouse->id]) }}" class="btn-icon view" title="Lihat Stok">
                                            📊
                                        </a>
                                        <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn-icon edit" title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus gudang ini? Semua data terkait (pergerakan stok, dll.) akan ikut terhapus. Tindakan ini tidak dapat dibatalkan!');">
                                            
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
                                        <div class="empty-state-icon">🏭</div>
                                        <h3 class="empty-state-title">Belum ada gudang</h3>
                                        <p class="empty-state-description">Mulai dengan menambahkan gudang pertama Anda</p>
                                        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">
                                            <span>+</span>
                                            <span>Tambah Gudang</span>
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