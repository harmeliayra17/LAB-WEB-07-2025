@extends('layouts.app')

@section('title', 'Tambah Kategori')

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
        <span>Tambah Baru</span>
    </div>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">➕</span>
                Tambah Kategori Baru
            </h1>
        </div>
        <p class="page-subtitle">Isi form di bawah untuk menambahkan kategori baru</p>
    </div>

    <div class="card">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            
            <div class="card-header">
                <h3 class="card-header-title">
                    <span>📋</span>
                    Informasi Kategori
                </h3>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label">Nama Kategori *</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        class="form-input" 
                        placeholder="Contoh: Elektronik, Furniture, Pakaian"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                    <textarea 
                        id="description"
                        name="description" 
                        class="form-textarea"
                        placeholder="Deskripsi singkat tentang kategori ini..."
                    ></textarea>
                </div>
            </div>

            <div class="card-body" style="border-top: 1px solid var(--border); background: #f8fafc; display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn btn-primary">
                    <span>Simpan Kategori</span>
                </button>
            </div>
        </form>
    </div>
@endsection