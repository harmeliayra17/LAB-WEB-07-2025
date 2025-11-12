@extends('layouts.app')

@section('title', 'Detail Produk: ' . $product->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Produk</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>{{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th colspan="2" class="bg-light">Informasi Dasar Produk</th>
                </tr>
                <tr>
                    <th width="200px">ID</th>
                    <td>{{ $product->id }}</td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td>Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $product->category->name ?? 'Tidak Terkategori' }}</td>
                </tr>
                
                <tr>
                    <th colspan="2" class="bg-light">Informasi Detail Produk</th>
                </tr>
                <tr>
                    <th>Berat</th>
                    <td>{{ $product->detail->weight ?? '-' }} kg</td>
                </tr>
                <tr>
                    <th>Ukuran</th>
                    <td>{{ $product->detail->size ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td style="white-space: pre-wrap;">{{ $product->detail->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th colspan="2" class="bg-light">Informasi Lain</th>
                </tr>
                 <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $product->created_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Diperbarui Pada</th>
                    <td>{{ $product->updated_at->format('d M Y, H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer d-flex gap-2">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit Produk</a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus Produk</button>
            </form>
        </div>
    </div>
@endsection