@extends('layouts.app')
@section('content')

<h2 class="text-primary mb-4 fw-bold">{{ isset($category) ? 'Edit Kategori: ' . $category->name : 'Tambah Kategori Baru' }}</h2>

<div class="card shadow-sm p-4">
    <form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" method="POST">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name ?? old('name') }}" placeholder="Contoh: Elektronik, Pakaian, Makanan" required>
        </div>

        <div class="mb-4">
            <label for="description" class="form-label fw-semibold">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Jelaskan jenis produk yang termasuk dalam kategori ini.">{{ $category->description ?? old('description') }}</textarea>
        </div>

        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success fw-bold shadow-sm">
                <i class="bi bi-save me-1"></i> {{ isset($category) ? 'Simpan Perubahan' : 'Simpan Kategori' }}
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection