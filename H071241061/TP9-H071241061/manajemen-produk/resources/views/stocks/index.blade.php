@extends('layouts.app')
@section('title', 'Manajemen Stok')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-pink-700">Manajemen Stok</h1>
            <p class="mt-1 text-sm text-pink-400">Pantau dan kelola stok produk per gudang 💫</p>
        </div>
        <a href="{{ route('stocks.transfer') }}" 
           class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-2xl shadow-md transition-all duration-200 transform hover:scale-105">
            <i class="fas fa-exchange-alt mr-2"></i>Transfer Stok
        </a>
    </div>

    <!-- Filter Gudang -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-pink-100">
        <form method="GET" action="{{ route('stocks.index') }}">
            <div class="flex gap-3">
                <select name="warehouse_id" 
                    class="flex-1 px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent"
                    onchange="this.form.submit()">
                    <option value="">🏢 Pilih Gudang untuk melihat stok...</option>
                    @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }} - {{ $warehouse->location }}
                    </option>
                    @endforeach
                </select>
                @if(request('warehouse_id'))
                <a href="{{ route('stocks.index') }}"
                   class="px-4 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 font-medium rounded-xl transition-all duration-200">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Stok -->
    @if($selectedWarehouse)
        @if($stocks->count() > 0)
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden border border-pink-100">
            <div class="px-6 py-4 bg-pink-50 border-b border-pink-100">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-pink-700">
                        <i class="fas fa-warehouse mr-2"></i>Stok di {{ $selectedWarehouse->name }}
                    </h3>
                    <span class="text-sm text-pink-500">{{ $stocks->count() }} Produk</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-pink-100">
                    <thead class="bg-pink-100/60">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-pink-600 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-pink-600 uppercase tracking-wider">Berat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-pink-50">
                        @foreach($stocks as $product)
                        <tr class="hover:bg-pink-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-pink-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-cube text-pink-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $product->detail->size ?? '-' }}</p>
                                    </div>
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
                            <td class="px-6 py-4 text-center">
                                @php
                                    $stock = $product->pivot->quantity;
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                    {{ $stock > 20 ? 'bg-green-100 text-green-800' : ($stock > 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ $product->detail->weight ?? '-' }} kg
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-pink-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right text-sm font-semibold text-pink-700">
                                Total Stok:
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold text-pink-600">
                                    {{ $stocks->sum('pivot.quantity') }}
                                </span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-12 text-center border border-pink-100">
            <i class="fas fa-box-open text-pink-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg font-medium">Tidak ada stok di gudang ini</p>
            <p class="text-gray-400 text-sm mt-2">Gudang {{ $selectedWarehouse->name }} masih kosong</p>
            <a href="{{ route('stocks.transfer') }}" 
               class="mt-5 inline-flex items-center px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-2xl transition-all duration-200">
                <i class="fas fa-plus mr-2"></i>Tambah Stok Pertama
            </a>
        </div>
        @endif
    @else
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-16 text-center border border-pink-100">
        <i class="fas fa-warehouse text-pink-300 text-6xl mb-4"></i>
        <p class="text-gray-600 text-xl font-semibold mb-2">Pilih Gudang</p>
        <p class="text-gray-400">Silakan pilih gudang dari dropdown di atas untuk melihat stok produk ✨</p>
    </div>
    @endif
</div>
@endsection