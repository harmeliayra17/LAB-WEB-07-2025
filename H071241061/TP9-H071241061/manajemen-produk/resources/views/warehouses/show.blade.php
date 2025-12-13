@extends('layouts.app')
@section('title', 'Detail Gudang')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-pink-700">Detail Gudang</h1>
            <p class="mt-1 text-sm text-pink-400">Informasi lengkap gudang dan stok produk</p>
        </div>
        <a href="{{ route('warehouses.index') }}" 
           class="px-4 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold rounded-2xl transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-sm border border-pink-100 rounded-2xl shadow-md overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-pink-500">Nama Gudang</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $warehouse->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-pink-500">Jumlah Produk</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $warehouse->products->count() }} Produk</p>
                </div>
            </div>

            <div>
                <p class="text-sm font-medium text-pink-500">Lokasi</p>
                <p class="mt-1 text-gray-800">{{ $warehouse->location ?? '-' }}</p>
            </div>

            <div class="flex gap-3 pt-4 border-t border-pink-100">
                <a href="{{ route('warehouses.edit', $warehouse) }}" 
                   class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-xl transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus gudang ini?')">
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

    <!-- Daftar Produk -->
    @if($warehouse->products->count() > 0)
    <div class="bg-white/80 backdrop-blur-sm border border-pink-100 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-pink-50 border-b border-pink-100">
            <h3 class="text-lg font-semibold text-pink-700">Daftar Produk di Gudang Ini</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-pink-100">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase">Harga</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-pink-600 uppercase">Stok</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-pink-50">
                    @foreach($warehouse->products as $product)
                    <tr class="hover:bg-pink-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="h-10 w-10 bg-pink-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-cube text-pink-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->category->name ?? '-' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $product->pivot->quantity > 10 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product->pivot->quantity }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-8 text-center border border-pink-100">
        <i class="fas fa-box-open text-pink-300 text-5xl mb-3"></i>
        <p class="text-gray-500 text-lg">Belum ada produk di gudang ini</p>
        <a href="{{ route('products.create') }}" class="mt-3 inline-block text-pink-500 hover:text-pink-700 font-medium">
            Tambah produk pertama
        </a>
    </div>
    @endif
</div>
@endsection
