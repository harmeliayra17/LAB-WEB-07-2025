@extends('layouts.app')
@section('title', 'Edit Gudang')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-extrabold text-pink-700">Edit Gudang</h1>
        <p class="mt-2 text-pink-500">Ubah informasi gudang kamu 🌸</p>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-pink-100 p-8">
        <form action="{{ route('warehouses.update', $warehouse) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-pink-700 mb-2">
                    Nama Gudang <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $warehouse->name) }}" required
                    class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:outline-none">
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold text-pink-700 mb-2">Lokasi</label>
                <textarea name="location" id="location" rows="3"
                    class="w-full px-4 py-3 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:outline-none">{{ old('location', $warehouse->location) }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-full shadow-md transition-all duration-300 hover:scale-105 hover:shadow-pink-200">
                    <i class="fas fa-save mr-2"></i> Update
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
