@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Manajemen Gudang</h2>
    <a href="{{ route('warehouses.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Gudang Baru
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 30%;">Nama Gudang</th>
                    <th style="width: 50%;">Lokasi</th>
                    <th class="text-center" style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouses as $wh)
                <tr>
                    <td class="fw-bold">{{ $wh->name }}</td>
                    <td class="text-muted">{{ $wh->location ?? 'Lokasi belum diset' }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1"> 
                            <a href="{{ route('warehouses.edit', $wh) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('warehouses.destroy', $wh) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus gudang {{ $wh->name }}?')"><i class="bi bi-trash" title="Hapus"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection