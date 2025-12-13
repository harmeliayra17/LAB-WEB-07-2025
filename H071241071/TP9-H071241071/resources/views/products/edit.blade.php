@extends('layouts.app')
@section('content')

<h2 class="text-primary mb-4 fw-bold">Tambah Produk Baru</h2>

<div class="card shadow-sm p-4">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 border-end pe-md-4">
                    <h5 class="mb-3 text-secondary"><i class="bi bi-info-circle me-1"></i> Informasi Dasar</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Laptop Gaming X10" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="Contoh: 5000000" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Tidak ada kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 ps-md-4">
                    <h5 class="mb-3 text-secondary"><i class="bi bi-file-text me-1"></i> Detail Spesifikasi</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Detail</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi lengkap produk..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Berat (kg) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="weight" class="form-control" placeholder="Contoh: 1.5" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ukuran</label>
                        <input type="text" name="size" class="form-control" placeholder="Contoh: L x P x T (cm) atau S/M/L">
                    </div>
                </div>
            </div>
            
            <hr class="mt-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success fw-bold shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection