@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-pink-700">Tambah Produk Baru</h1>
        <p class="mt-1 text-sm text-pink-400">Isi form di bawah untuk menambahkan produk</p>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-pink-100">
        <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="border-b border-pink-100 pb-4">
                <h3 class="text-lg font-semibold text-pink-700 mb-4">Informasi Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" id="category_id"
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-400">Rp</span>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required
                                class="w-full pl-10 pr-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-pink-700 mb-4">Detail Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent"
                            placeholder="Deskripsi produk..."></textarea>
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Berat (kg) <span class="text-red-500">*</span></label>
                        <input type="number" name="weight" id="weight" value="{{ old('weight') }}" required
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                    </div>

                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-2">Ukuran</label>
                        <input type="text" name="size" id="size" value="{{ old('size') }}"
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-pink-100">
                <button type="submit"
                    class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-4 rounded-2xl shadow-md transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Simpan Produk
                </button>
                <a href="{{ route('products.index') }}"
                    class="flex-1 bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-3 px-4 rounded-2xl text-center transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
