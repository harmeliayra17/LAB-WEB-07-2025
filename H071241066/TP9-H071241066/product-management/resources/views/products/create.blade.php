@extends('layouts.app')

@section('title', 'Tambah Produk')

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
        <span>Tambah Baru</span>
    </div>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">➕</span>
                Tambah Produk Baru
            </h1>
        </div>
        <p class="page-subtitle">Isi form di bawah untuk menambahkan produk baru</p>
    </div>

    <div class="card">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            <div class="card-header">
                <h3 class="card-header-title">
                    <span>📋</span>
                    Data Utama Produk
                </h3>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label">Nama Produk *</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        class="form-input" 
                        value="{{ old('name') }}" 
                        placeholder="Contoh: Laptop ASUS ROG"
                        required
                    >
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="price" class="form-label">Harga *</label>
                        <input 
                            type="number" 
                            id="price"
                            name="price" 
                            class="form-input" 
                            step="0.01" 
                            value="{{ old('price') }}" 
                            placeholder="Contoh: 15000000"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">-- Pilih Kategori (Opsional) --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-header" style="border-top: 1px solid var(--border);">
                <h3 class="card-header-title">
                    <span>📝</span>
                    Detail Spesifikasi
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Produk</label>
                    <textarea 
                        id="description"
                        name="description" 
                        class="form-textarea"
                        placeholder="Deskripsi lengkap produk..."
                    >{{ old('description') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="weight" class="form-label">Berat (kg) *</label>
                        <input 
                            type="number" 
                            id="weight"
                            name="weight" 
                            class="form-input" 
                            step="0.01" 
                            value="{{ old('weight') }}" 
                            placeholder="Contoh: 2.5"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="size" class="form-label">Ukuran</label>
                        <input 
                            type="text" 
                            id="size"
                            name="size" 
                            class="form-input" 
                            value="{{ old('size') }}"
                            placeholder="Contoh: 15.6 inch"
                        >
                    </div>
                </div>
            </div>

            <div class="card-body" style="border-top: 1px solid var(--border); background: #f8fafc; display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn btn-primary">
                    <span>Simpan Produk</span>
                </button>
            </div>
        </form>
    </div>
@endsection