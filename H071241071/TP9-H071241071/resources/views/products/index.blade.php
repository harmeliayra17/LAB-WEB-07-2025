@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Daftar Produk</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 40%;">Nama Produk</th>
                    <th style="width: 25%;">Kategori</th>
                    <th style="width: 20%;">Harga</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td class="fw-bold">{{ $p->name }}</td>
                    <td><span class="badge text-bg-secondary">{{ $p->category?->name ?? 'Tidak Berkategori' }}</span></td>
                    <td class="fw-semibold">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                    <td class="text-center">
                        
                        <div class="d-flex justify-content-center gap-1"> 
                            <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-info text-white" title="Lihat"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('products.destroy', $p) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk {{ $p->name }}?')"><i class="bi bi-trash" title="Hapus"></i></button>
                            </form>
                        </div>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $products->links() }}
</div>

@endsection