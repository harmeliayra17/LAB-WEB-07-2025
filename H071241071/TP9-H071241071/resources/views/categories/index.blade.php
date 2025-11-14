@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Manajemen Kategori</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori Baru
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td class="fw-bold">{{ $category->name }}</td>
                    <td class="text-muted">{{ $category->description ?? 'Tidak ada deskripsi' }}</td> 
                    <td class="text-center" style="width: 200px;">
                        
                        <div class="d-flex justify-content-center gap-1"> 
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info text-white" title="Lihat"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?')" title="Hapus"><i class="bi bi-trash"></i></button>
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
    {{ $categories->links() }}
</div>

@endsection