@extends('layouts.app')

@section('title', 'Edit Stok Gudang')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Edit Stok Gudang</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="text-red-700 hover:text-red-900 focus:outline-none" onclick="this.parentElement.style.display='none';">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        @endif
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6">
            <form action="{{ route('product-warehouse.update', $productWarehouse->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 p-2" value="{{ old('quantity', $productWarehouse->quantity) }}" required min="0">
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 shadow-md">Update</button>
                    <a href="{{ route('product-warehouse.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-300 shadow-md">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
