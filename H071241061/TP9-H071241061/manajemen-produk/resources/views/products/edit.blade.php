@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-pink-700">Edit Produk</h1>
        <p class="mt-1 text-sm text-pink-400">Ubah informasi produk Anda 🌸</p>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-pink-100">
        <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="border-b border-pink-100 pb-4">
                <h3 class="text-lg font-semibold text-pink-700 mb-4">Informasi Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" id="category_id"
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('category_id') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-400">Rp</span>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required step="0.01"
                                class="w-full pl-10 pr-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('price') border-red-500 @enderror">
                        </div>
                        @error('price')
                        <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-pink-700 mb-4">Detail Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('description') border-red-500 @enderror"
                            placeholder="Deskripsi produk...">{{ old('description', $product->detail->description ?? '') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat (kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="weight" id="weight" value="{{ old('weight', $product->detail->weight ?? '') }}" required step="0.01" min="0.01"
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('weight') border-red-500 @enderror">
                        @error('weight')
                        <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-2">Ukuran</label>
                        <input type="text" name="size" id="size" value="{{ old('size', $product->detail->size ?? '') }}"
                            class="w-full px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('size') border-red-500 @enderror"
                            placeholder="Contoh: L, XL, XXL">
                        @error('size')
                        <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-pink-100">
                <button type="submit"
                    class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-4 rounded-2xl shadow-md transition-all duration-200 transform hover:scale-105 hover:shadow-pink-200">
                    <i class="fas fa-save mr-2"></i>Update Produk
                </button>
                <a href="{{ route('products.index') }}"
                    class="flex-1 bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-3 px-4 rounded-2xl text-center transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Stok -->
    @if($product->warehouses->count() > 0)
    <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-pink-100">
        <h3 class="text-lg font-semibold text-pink-700 mb-4">
            <i class="fas fa-warehouse mr-2"></i>Stok Saat Ini
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($product->warehouses as $warehouse)
            <div class="flex justify-between items-center p-3 bg-pink-50 rounded-xl">
                <div>
                    <p class="font-medium text-gray-900 text-sm">{{ $warehouse->name }}</p>
                    <p class="text-xs text-gray-500">{{ Str::limit($warehouse->location, 30) }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                    {{ $warehouse->pivot->quantity > 10 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $warehouse->pivot->quantity }}
                </span>
            </div>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t border-pink-100 flex justify-between items-center">
            <span class="font-semibold text-gray-900">Total Stok Semua Gudang:</span>
            <span class="text-2xl font-bold text-pink-600">
                {{ $product->warehouses->sum('pivot.quantity') }}
            </span>
        </div>
    </div>
    @endif
</div>
@endsection