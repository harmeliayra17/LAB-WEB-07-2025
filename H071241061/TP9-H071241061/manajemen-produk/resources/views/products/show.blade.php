@extends('layouts.app')
@section('title', 'Detail Produk')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-pink-700">Detail Produk</h1>
            <p class="mt-1 text-sm text-pink-400">Informasi lengkap produk</p>
        </div>
        <a href="{{ route('products.index') }}" 
           class="px-4 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold rounded-2xl transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Product Info -->
        <div class="lg:col-span-2">
            <div class="bg-white/80 backdrop-blur-sm border border-pink-100 rounded-2xl shadow-md overflow-hidden p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $product->name }}</h2>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm font-medium text-pink-500">Kategori</p>
                        <p class="mt-1">
                            @if($product->category)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-700">
                                {{ $product->category->name }}
                            </span>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-pink-500">Harga</p>
                        <p class="mt-1 text-2xl font-bold text-pink-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-pink-100 pt-4">
                    <h3 class="font-semibold text-pink-700 mb-3">Detail Produk</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Berat</p>
                            <p class="mt-1 text-gray-900">{{ $product->detail->weight ?? '-' }} kg</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Ukuran</p>
                            <p class="mt-1 text-gray-900">{{ $product->detail->size ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500 mb-1">Deskripsi</p>
                        <p class="text-gray-700 leading-relaxed">{{ $product->detail->description ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t border-pink-100 mt-6">
                    <a href="{{ route('products.edit', $product) }}" 
                       class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-xl transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Warehouse Info -->
        <div>
            <div class="bg-white/80 backdrop-blur-sm border border-pink-100 rounded-2xl shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-pink-50 border-b border-pink-100">
                    <h3 class="text-lg font-semibold text-pink-700">Stok di Gudang</h3>
                </div>
                <div class="p-6">
                    @if($product->warehouses->count() > 0)
                    <ul class="space-y-3">
                        @foreach($product->warehouses as $warehouse)
                        <li class="flex justify-between items-center p-3 bg-pink-50 rounded-xl">
                            <div>
                                <p class="font-medium text-gray-900">{{ $warehouse->name }}</p>
                                <p class="text-xs text-gray-500">{{ $warehouse->location }}</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $warehouse->pivot->quantity > 10 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $warehouse->pivot->quantity }}
                            </span>
                        </li>
                        @endforeach
                    </ul>

                    <div class="mt-4 pt-4 border-t border-pink-100">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Total Stok</span>
                            <span class="text-xl font-bold text-pink-600">
                                {{ $product->warehouses->sum('pivot.quantity') }}
                            </span>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-8">Belum ada stok di gudang</p>
                    @endif

                    <a href="{{ route('stocks.transfer') }}" 
                       class="mt-5 block w-full text-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-xl transition-colors duration-200">
                        <i class="fas fa-exchange-alt mr-2"></i>Transfer Stok
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
