@extends('layouts.app')

@section('title', 'Detail Kategori: ' . $category->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Kategori</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200px">ID</th>
                    <td>{{ $category->id }}</td>
                </tr>
                <tr>
                    <th>Nama Kategori</th>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $category->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $category->created_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Diperbarui Pada</th>
                    <td>{{ $category->updated_at->format('d M Y, H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer d-flex gap-2">
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit Kategori</a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus Kategori</button>
            </form>
        </div>
    </div>
@endsection