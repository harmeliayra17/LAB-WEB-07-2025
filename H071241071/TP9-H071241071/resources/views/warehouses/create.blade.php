@extends('layouts.app')
@section('content')

<h2 class="text-primary mb-4 fw-bold">{{ isset($warehouse) ? 'Edit Gudang: ' . $warehouse->name : 'Tambah Gudang Baru' }}</h2>

<div class="card shadow-sm p-4">
    <div class="card-body">
        <form action="{{ isset($warehouse) ? route('warehouses.update', $warehouse) : route('warehouses.store') }}" method="POST">
            @csrf
            @if(isset($warehouse)) @method('PUT') @endif

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Gudang <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" value="{{ $warehouse->name ?? old('name') }}" class="form-control" placeholder="Contoh: Gudang Utama Jakarta" required>
            </div>
            
            <div class="mb-4">
                <label for="location" class="form-label fw-semibold">Lokasi/Alamat Lengkap</label>
                <textarea name="location" id="location" class="form-control" rows="3" placeholder="Contoh: Jl. Sudirman No. 12, Jakarta Selatan">{{ $warehouse->location ?? old('location') }}</textarea>
                <small class="text-muted">Alamat yang jelas memudahkan manajemen logistik.</small>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('warehouses.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success fw-bold shadow-sm">
                    <i class="bi bi-save me-1"></i> {{ isset($warehouse) ? 'Simpan Perubahan' : 'Simpan Gudang' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection