@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Detail Kategori: {{ $category->name }}</h2>
    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning shadow-sm">
        <i class="bi bi-pencil-square me-1"></i> Edit Kategori
    </a>
</div>

<div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Informasi Lengkap</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="text-muted small mb-0">Nama Kategori</label>
                <p class="fw-bold fs-5">{{ $category->name }}</p>
            </div>
            <div class="col-md-12 mb-3">
                <label class="text-muted small mb-0">Deskripsi</label>
                <p class="text-break">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <label class="text-muted small mb-0">Dibuat Pada</label>
                <p>{{ $category->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small mb-0">Diperbarui Pada</label>
                <p>{{ $category->updated_at->format('d F Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('categories.index') }}" class="btn btn-secondary mt-4">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Kategori
</a>
@endsection