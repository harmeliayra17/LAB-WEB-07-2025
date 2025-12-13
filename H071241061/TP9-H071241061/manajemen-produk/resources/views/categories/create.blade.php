@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-extrabold text-pink-700">Tambah Kategori Baru</h1>
        <p class="mt-2 text-pink-500">Isi form di bawah untuk menambahkan kategori produk 💫</p>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-pink-100 p-8">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Input Nama -->
            <div>
                <label for="name" class="block text-sm font-semibold text-pink-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-pink-50/40 placeholder-pink-300 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:outline-none transition-all duration-200 @error('name') border-red-500 @enderror">
                @error('name')
                <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-semibold text-pink-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-pink-50/40 placeholder-pink-300 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:outline-none transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-4 pt-4">
                <button type="submit"
                    class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-4 rounded-full shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-pink-200">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>

                <a href="{{ route('categories.index') }}"
                    class="flex-1 bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-3 px-4 rounded-full text-center transition-all duration-300 shadow-sm hover:shadow-md">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
