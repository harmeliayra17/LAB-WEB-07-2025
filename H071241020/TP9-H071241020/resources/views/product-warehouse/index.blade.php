@extends('layouts.app')

@section('title', 'Daftar Stok Gudang')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Daftar Stok Gudang</h1>
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('product-warehouse.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300 shadow-md flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Tambah Stok
            </a>
        </div>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="text-green-700 hover:text-green-900 focus:outline-none" onclick="this.parentElement.style.display='none';">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        @endif
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-4 text-left text-gray-600 font-medium">Produk</th>
                        <th class="p-4 text-left text-gray-600 font-medium">Gudang</th>
                        <th class="p-4 text-left text-gray-600 font-medium">Jumlah</th>
                        <th class="p-4 text-left text-gray-600 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productWarehouses as $item)
                        <tr>
                            <td class="p-4">{{ $item->product->name ?? '-' }}</td>
                            <td class="p-4">{{ $item->warehouse->name ?? '-' }}</td>
                            <td class="p-4">{{ $item->quantity }}</td>
                            <td class="p-4 flex space-x-2">
                                <a href="{{ route('product-warehouse.edit', $item->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                <a href="{{ route('product-warehouse.show', $item->id) }}" class="text-blue-500 hover:text-blue-700">Show</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada data stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
