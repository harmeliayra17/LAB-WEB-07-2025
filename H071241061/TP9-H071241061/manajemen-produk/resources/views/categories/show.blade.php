@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-extrabold text-pink-700">Detail Kategori</h1>
            <p class="mt-1 text-pink-500">Informasi lengkap kategori produk 💫</p>
        </div>
        <a href="{{ route('categories.index') }}"
           class="px-5 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold rounded-full transition-all duration-200 shadow-sm hover:shadow-md">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Card Detail -->
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-pink-100 p-8 space-y-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-sm font-medium text-pink-600">Nama Kategori</p>
                <p class="mt-1 text-xl font-semibold text-gray-800">{{ $category->name }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-pink-600">Jumlah Produk</p>
                <p class="mt-1 text-xl font-semibold text-gray-800">{{ $category->products->count() }} Produk</p>
            </div>
        </div>

        <div>
            <p class="text-sm font-medium text-pink-600">Deskripsi</p>
            <p class="mt-1 text-gray-700">{{ $category->description ?? '-' }}</p>
        </div>

        <div class="flex gap-3 pt-4">
            <a href="{{ route('categories.edit', $category) }}"
               class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-full transition-all duration-200 shadow-md hover:shadow-pink-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus kategori ini? 😢')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-5 py-2 bg-red-400 hover:bg-red-500 text-white font-semibold rounded-full transition-all duration-200 shadow-md">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Produk -->
    @if($category->products->count() > 0)
    <div class="mt-8 bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-pink-100 overflow-hidden">
        <div class="px-6 py-4 bg-pink-50 border-b border-pink-100">
            <h3 class="text-lg font-semibold text-pink-700">Produk dalam Kategori Ini</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-pink-100 text-sm">
                <thead class="bg-pink-100/60">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase">No</th>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase">Produk</th>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase">Harga</th>
                        <th class="px-6 py-3 font-semibold text-right text-pink-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-pink-50">
                    @foreach($category->products as $product)
                    <tr class="hover:bg-pink-50 transition-all duration-200">
                        <td class="px-6 py-4 text-gray-600">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 flex items-center">
                            <div class="h-10 w-10 bg-pink-100 text-pink-600 flex items-center justify-center rounded-full shadow-sm">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div class="ml-3">
                                <div class="font-medium text-gray-800">{{ $product->name }}</div>
                                <div class="text-xs text-gray-500">{{ $product->detail->weight ?? '-' }} kg</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-800 font-semibold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('products.show', $product) }}"
                               class="text-pink-600 hover:text-pink-800 transition-all duration-200">
                                <i class="fas fa-eye mr-1"></i>Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="mt-8 bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-pink-100 p-10 text-center">
        <i class="fas fa-box-open text-pink-300 text-5xl mb-4"></i>
        <p class="text-pink-600 text-lg font-medium">Belum ada produk dalam kategori ini</p>
        <a href="{{ route('products.create') }}"
           class="mt-4 inline-block text-pink-600 hover:text-pink-800 font-semibold transition-all">
            <i class="fas fa-plus mr-2"></i>Tambah produk pertama ✨
        </a>
    </div>
    @endif
</div>
@endsection
