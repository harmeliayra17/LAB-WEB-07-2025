@extends('layouts.app')

@section('title', 'Tambah Gudang')

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
        <span>Tambah Baru</span>
    </div>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">➕</span>
                Tambah Gudang Baru
            </h1>
        </div>
        <p class="page-subtitle">Isi form di bawah untuk menambahkan gudang baru</p>
    </div>

    <div class="card">
        <form action="{{ route('warehouses.store') }}" method="POST">
            @csrf
            
            <div class="card-header">
                <h3 class="card-header-title">
                    <span>📋</span>
                    Informasi Gudang
                </h3>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label">Nama Gudang *</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        class="form-input" 
                        value="{{ old('name') }}" 
                        placeholder="Contoh: Gudang Makassar, Gudang Gowa"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Lokasi Gudang (Opsional)</label>
                    <textarea 
                        id="location"
                        name="location" 
                        class="form-textarea"
                        placeholder="Alamat lengkap gudang..."
                    >{{ old('location') }}</textarea>
                </div>
            </div>

            <div class="card-body" style="border-top: 1px solid var(--border); background: #f8fafc; display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn btn-primary">
                    <span>Simpan Gudang</span>
                </button>
            </div>
        </form>
    </div>
@endsection
