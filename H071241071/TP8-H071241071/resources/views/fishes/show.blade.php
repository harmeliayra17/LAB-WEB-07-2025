@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-4">Detail Ikan: {{ $fish->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-lg">
            <div class="col-span-1">
                <p class="font-semibold text-gray-700">Rarity:</p>
                <p class="mt-1 text-gray-900 font-medium">{{ $fish->rarity }}</p>
            </div>
            <div class="col-span-1">
                <p class="font-semibold text-gray-700">Berat:</p>
                <p class="mt-1 text-gray-900">{{ $fish->formatted_weight }}</p>
            </div>
            <div class="col-span-1">
                <p class="font-semibold text-gray-700">Harga Jual:</p>
                <p class="mt-1 text-gray-900">{{ $fish->formatted_price }}</p>
            </div>
            <div class="col-span-1">
                <p class="font-semibold text-gray-700">Probabilitas Tertangkap:</p>
                <p class="mt-1 text-gray-900">{{ $fish->formatted_probability }}</p>
            </div>
            <div class="col-span-full pt-4 border-t mt-4">
                <p class="font-semibold text-gray-700">Deskripsi:</p>
                <p class="mt-1 text-gray-900 italic">{{ $fish->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
            <div class="col-span-1 mt-4">
                <p class="text-sm text-gray-500">Dibuat:</p>
                <p class="text-sm text-gray-900">{{ $fish->created_at }}</p>
            </div>
            <div class="col-span-1 mt-4">
                <p class="text-sm text-gray-500">Diupdate:</p>
                <p class="text-sm text-gray-900">{{ $fish->updated_at }}</p>
            </div>
        </div>

        <div class="mt-8 flex space-x-3">
            <a href="{{ route('fishes.edit', $fish) }}" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                Edit
            </a>
            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                    Hapus
                </button>
            </form>
            <a href="{{ route('fishes.index') }}" class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Kembali
            </a>
        </div>
    </div>
@endsection