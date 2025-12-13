@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-blue-600 mb-8">Dashboard Manajemen Produk</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Kategori</h2>
                <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Category::count() }}</p>
                <a href="{{ route('categories.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">Lihat Detail</a>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Produk</h2>
                <p class="text-3xl font-bold text-green-600">{{ \App\Models\Product::count() }}</p>
                <a href="{{ route('products.index') }}" class="text-green-500 hover:text-green-700 mt-2 inline-block">Lihat Detail</a>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Gudang</h2>
                <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\Warehouse::count() }}</p>
                <a href="{{ route('warehouses.index') }}" class="text-yellow-500 hover:text-yellow-700 mt-2 inline-block">Lihat Detail</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('categories.index') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 mb-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                </svg>
                <h2 class="text-xl font-semibold">Kategori</h2>
                <p class="text-gray-200">Kelola daftar kategori produk.</p>
            </a>
            <a href="{{ route('products.index') }}" class="bg-green-500 text-white p-6 rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 mb-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 7H3V5h18v2zm0 6H3v-2h18v2zm0 6H3v-2h18v2z"/>
                </svg>
                <h2 class="text-xl font-semibold">Produk</h2>
                <p class="text-gray-200">Kelola daftar produk.</p>
            </a>
            <a href="{{ route('warehouses.index') }}" class="bg-yellow-500 text-white p-6 rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-300 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 mb-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm10 16H4V8h16v12z"/>
                </svg>
                <h2 class="text-xl font-semibold">Gudang</h2>
                <p class="text-gray-200">Kelola daftar gudang.</p>
            </a>
            <a href="{{ route('product-details.index') }}" class="bg-indigo-500 text-white p-6 rounded-lg shadow-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 mb-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                </svg>
                <h2 class="text-xl font-semibold">Detail Produk</h2>
                <p class="text-gray-200">Kelola detail produk.</p>
            </a>
            <a href="{{ route('product-warehouse.index') }}" class="bg-purple-500 text-white p-6 rounded-lg shadow-md hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 mb-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm6 16H4v-8h12v8zm0-10H4V8h12v2z"/>
                </svg>
                <h2 class="text-xl font-semibold">Stok Gudang</h2>
                <p class="text-gray-200">Kelola stok di gudang.</p>
            </a>
        </div>
    </div>
@endsection
