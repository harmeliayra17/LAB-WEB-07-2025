@extends('layouts.app')

@section('title', 'Edit Kategori')

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
        <span>Edit</span>
    </div>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">✏️</span>
                Edit Kategori
            </h1>
        </div>
        <p class="page-subtitle">Perbarui informasi kategori: <strong>{{ $category->name }}</strong></p>
    </div>

    <div class="card">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                        value="{{ old('name', $category->name) }}" 
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
                    >{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <div class="card-body" style="border-top: 1px solid var(--border); background: #f8fafc; display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn btn-success">
                    <span>Update Kategori</span>
                </button>
            </div>
        </form>
    </div>
@endsection