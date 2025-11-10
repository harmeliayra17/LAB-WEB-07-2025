@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Detail Kategori Produk</h1>
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6 space-y-6">
            <div class="flex justify-between items-center border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-700">Informasi Kategori</h2>
                <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-300">Kembali</a>
            </div>
            <div><strong class="text-gray-700">ID:</strong> <span class="text-gray-900">{{ $category->id }}</span></div>
            <div><strong class="text-gray-700">Nama Kategori:</strong> <span class="text-gray-900">{{ $category->name }}</span></div>
            <div><strong class="text-gray-700">Deskripsi:</strong> <span class="text-gray-900">{{ $category->description ?? '-' }}</span></div>
            <div><strong class="text-gray-700">Dibuat pada:</strong> <span class="text-gray-900">{{ $category->created_at }}</span></div>
            <div><strong class="text-gray-700">Diperbarui pada:</strong> <span class="text-gray-900">{{ $category->updated_at }}</span></div>
        </div>
    </div>
@endsection
