@extends('layouts.app')
@section('title', 'Tambah Gudang')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-extrabold text-pink-700">Tambah Gudang Baru</h1>
        <p class="mt-2 text-pink-500">Isi form di bawah untuk menambahkan gudang baru 💫</p>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-pink-100 p-8">
        <form action="{{ route('warehouses.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-pink-700 mb-2">
                    Nama Gudang <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    placeholder="Contoh: Gudang Makassar"
                    class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 placeholder-pink-300 focus:ring-2 focus:ring-pink-400 focus:outline-none @error('name') border-red-500 @enderror">
                @error('name')
                <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold text-pink-700 mb-2">Lokasi</label>
                <textarea name="location" id="location" rows="3" placeholder="Alamat lengkap gudang"
                    class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 placeholder-pink-300 focus:ring-2 focus:ring-pink-400 focus:outline-none @error('location') border-red-500 @enderror">{{ old('location') }}</textarea>
                @error('location')
                <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-full shadow-md transition-all duration-300 hover:scale-105 hover:shadow-pink-200">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a href="{{ route('warehouses.index') }}"
                    class="flex-1 bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-3 rounded-full text-center transition-all duration-300">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
