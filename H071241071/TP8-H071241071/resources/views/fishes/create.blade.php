@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow overflow-hidden sm:rounded-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-4">Tambah Ikan Baru</h1>

        <form method="POST" action="{{ route('fishes.store') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Ikan</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="rarity" class="block text-sm font-medium text-gray-700">Rarity</label>
                    <select name="rarity" id="rarity" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm @error('rarity') border-red-500 @enderror">
                        <option value="Common" {{ old('rarity') == 'Common' ? 'selected' : '' }}>Common</option>
                        <option value="Uncommon" {{ old('rarity') == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                        <option value="Rare" {{ old('rarity') == 'Rare' ? 'selected' : '' }}>Rare</option>
                        <option value="Epic" {{ old('rarity') == 'Epic' ? 'selected' : '' }}>Epic</option>
                        <option value="Legendary" {{ old('rarity') == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                        <option value="Mythic" {{ old('rarity') == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                        <option value="Secret" {{ old('rarity') == 'Secret' ? 'selected' : '' }}>Secret</option>
                    </select>
                    @error('rarity') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="base_weight_min" class="block text-sm font-medium text-gray-700">Berat Minimum (kg)</label>
                        <input type="number" step="0.01" name="base_weight_min" id="base_weight_min" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 @error('base_weight_min') border-red-500 @enderror" value="{{ old('base_weight_min') }}">
                        @error('base_weight_min') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="base_weight_max" class="block text-sm font-medium text-gray-700">Berat Maksimum (kg)</label>
                        <input type="number" step="0.01" name="base_weight_max" id="base_weight_max" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 @error('base_weight_max') border-red-500 @enderror" value="{{ old('base_weight_max') }}">
                        @error('base_weight_max') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="sell_price_per_kg" class="block text-sm font-medium text-gray-700">Harga Jual per kg (Coins)</label>
                    <input type="number" name="sell_price_per_kg" id="sell_price_per_kg" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 @error('sell_price_per_kg') border-red-500 @enderror" value="{{ old('sell_price_per_kg') }}">
                    @error('sell_price_per_kg') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="catch_probability" class="block text-sm font-medium text-gray-700">Probabilitas Tertangkap (%)</label>
                    <input type="number" step="0.01" name="catch_probability" id="catch_probability" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 @error('catch_probability') border-red-500 @enderror" value="{{ old('catch_probability') }}">
                    @error('catch_probability') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection