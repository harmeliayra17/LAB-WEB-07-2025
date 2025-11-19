@extends('layouts.app')
@section('title', 'Daftar Produk')
@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-pink-700">Produk</h1>
            <p class="mt-1 text-sm text-pink-400">Kelola katalog produk Anda</p>
        </div>
        <a href="{{ route('products.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-2xl shadow-md transition-all duration-200 transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Tambah Produk
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-pink-100">
        <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." 
                        class="w-full px-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                </div>
                <div>
                    <select name="category_id" 
                        class="w-full px-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden border border-pink-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-pink-100">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Berat</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-pink-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-pink-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-pink-50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="h-10 w-10 bg-pink-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-cube text-pink-500"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                <div class="text-xs text-gray-400">{{ $product->detail->size ?? '-' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->category)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-700">
                                {{ $product->category->name }}
                            </span>
                            @else
                            <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $product->detail->weight ?? '-' }} kg
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                            <a href="{{ route('products.show', $product) }}" class="text-pink-600 hover:text-pink-800">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cube text-pink-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-lg">Tidak ada produk ditemukan</p>
                                <a href="{{ route('products.create') }}" class="mt-4 text-pink-500 hover:text-pink-700">
                                    Tambah produk pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="bg-pink-50 px-4 py-3 border-t border-pink-100 sm:px-6">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
