{{-- resources/views/stocks/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    </div>
    <span>›</span>
    <div class="breadcrumb-item active">
        <span>📊 Manajemen Stok</span>
    </div>
@endsection

@section('topbar-actions')
    <a href="{{ route('stocks.history') }}" class="btn btn-secondary">
        <span>📜</span>
        <span>Riwayat Stok</span>
    </a>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">📊</span>
                Manajemen Stok Gudang
            </h1>
        </div>
        <p class="page-subtitle">Kelola stok produk dan transfer antar gudang</p>
    </div>

    <div class="filter-section">
        <form method="GET" action="{{ route('stocks.index') }}" style="display: flex; align-items: center; gap: 16px;">
            <div style="flex: 1;">
                <label for="warehouse_id" class="form-label" style="margin-bottom: 8px;">Filter Berdasarkan Gudang</label>
                <select name="warehouse_id" id="warehouse_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Tampilkan Semua Gudang --</option>
                    @foreach ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}" {{ $selectedWarehouseId == $warehouse->id ? 'selected' : '' }}>
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if ($selectedWarehouseId)
        <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--purple) 100%); color: white; padding: 16px 20px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; box-shadow: var(--shadow-md);">
            <span style="font-size: 24px;">🏭</span>
            <div>
                <div style="font-size: 13px; opacity: 0.9;">Menampilkan stok di:</div>
                <div style="font-size: 18px; font-weight: 700;">{{ $warehouses->firstWhere('id', $selectedWarehouseId)->name }}</div>
            </div>
        </div>
    @endif

    
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3 class="card-header-title">
                <span>📦</span>
                Daftar Stok Produk
            </h3>
        </div>
        <div class="card-body">
            @if ($stocks->isEmpty() && $selectedWarehouseId)
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3 class="empty-state-title">Tidak ada stok</h3>
                    <p class="empty-state-description">Tidak ada produk yang tercatat di gudang ini</p>
                </div>
            @else
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok (Quantity)</th>
                                <th>Status</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td style="font-weight: 600;">{{ $product->name }}</td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge badge-info">{{ $product->category->name }}</span>
                                        @else
                                            <span class="badge" style="background: #e2e8f0; color: #64748b;">Tanpa Kategori</span>
                                        @endif
                                    </td>
                                    <td style="font-weight: 700; color: var(--primary); font-size: 16px;">
                                        {{ $product->pivot->quantity }} unit
                                    </td>
                                    <td>
                                        @if($product->pivot->quantity > 50)
                                            <span class="badge badge-success">✓ Stok Banyak</span>
                                        @elseif($product->pivot->quantity > 10)
                                            <span class="badge badge-warning">⚠ Stok Sedang</span>
                                        @elseif($product->pivot->quantity > 0)
                                            <span class="badge badge-danger">⚠ Stok Rendah</span>
                                        @else
                                            <span class="badge" style="background: #f1f5f9; color: #64748b;">✕ Habis</span>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>


    <div class="card" style="border-left: 4px solid var(--success);">
        <div class="card-header" style="background: linear-gradient(to right, #f0fdf4 0%, #ffffff 100%);">
            <h3 class="card-header-title">
                <span>🔄</span>
                Form Transfer Stok (Masuk/Keluar)
            </h3>
        </div>
        <div class="card-body">
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                <div style="display: flex; gap: 12px; align-items: start;">
                    <span style="font-size: 20px;">💡</span>
                    <div>
                        <strong style="color: #166534; display: block; margin-bottom: 4px;">Cara Penggunaan:</strong>
                        <ul style="color: #166534; font-size: 14px; margin: 0; padding-left: 20px; line-height: 1.6;">
                            <li>Masukkan angka <strong>positif</strong> (contoh: <code style="background: white; padding: 2px 6px; border-radius: 4px;">+10</code>) untuk <strong>menambah</strong> stok</li>
                            <li>Masukkan angka <strong>negatif</strong> (contoh: <code style="background: white; padding: 2px 6px; border-radius: 4px;">-5</code>) untuk <strong>mengurangi</strong> stok</li>
                            <li>Stok tidak boleh menjadi negatif (minus akan ditolak)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('stocks.transfer') }}">
                @csrf
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                    <div class="form-group">
                        <label for="warehouse_id" class="form-label">Gudang Tujuan *</label>
                        <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                            <option value="">-- Pilih Gudang Tujuan --</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_id" class="form-label">Produk *</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="stock_value" class="form-label">Nilai Stok (+/-) *</label>
                    <input 
                        type="number" 
                        id="stock_value"
                        name="stock_value" 
                        class="form-input" 
                        placeholder="Contoh: 10 untuk menambah, -5 untuk mengurangi" 
                        value="{{ old('stock_value') }}"
                        required
                        style="font-size: 16px; font-weight: 600;"
                    >
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; padding-top: 12px; border-top: 1px solid var(--border);">
                    <button type="reset" class="btn btn-secondary">
                        <span>Reset Form</span>
                    </button>
                    <button type="submit" class="btn btn-success">
                        <span>Proses Transfer Stok</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
