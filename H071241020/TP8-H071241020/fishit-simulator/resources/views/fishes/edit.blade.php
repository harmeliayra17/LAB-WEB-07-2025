@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Edit Ikan</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('fishes.update', $fish->id) }}" method="POST" class="max-w-lg bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Ikan</label>
            <input type="text" name="name" id="name" value="{{ old('name', $fish->name) }}" required class="mt-1 p-2 w-full border rounded">
        </div>

        <div class="mb-4">
            <label for="rarity" class="block text-sm font-medium text-gray-700">Rarity</label>
            <select name="rarity" id="rarity" required class="mt-1 p-2 w-full border rounded">
                <option value="Common" {{ old('rarity', $fish->rarity) == 'Common' ? 'selected' : '' }}>Common</option>
                <option value="Uncommon" {{ old('rarity', $fish->rarity) == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                <option value="Rare" {{ old('rarity', $fish->rarity) == 'Rare' ? 'selected' : '' }}>Rare</option>
                <option value="Epic" {{ old('rarity', $fish->rarity) == 'Epic' ? 'selected' : '' }}>Epic</option>
                <option value="Legendary" {{ old('rarity', $fish->rarity) == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                <option value="Mythic" {{ old('rarity', $fish->rarity) == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                <option value="Secret" {{ old('rarity', $fish->rarity) == 'Secret' ? 'selected' : '' }}>Secret</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="base_weight_min" class="block text-sm font-medium text-gray-700">Berat Minimum (kg)</label>
            <input type="number" step="0.01" name="base_weight_min" id="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min) }}" required class="mt-1 p-2 w-full border rounded">
        </div>

        <div class="mb-4">
            <label for="base_weight_max" class="block text-sm font-medium text-gray-700">Berat Maksimum (kg)</label>
            <input type="number" step="0.01" name="base_weight_max" id="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max) }}" required class="mt-1 p-2 w-full border rounded">
        </div>

        <div class="mb-4">
            <label for="sell_price_per_kg" class="block text-sm font-medium text-gray-700">Harga Jual per kg (Coins)</label>
            <input type="number" name="sell_price_per_kg" id="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}" required class="mt-1 p-2 w-full border rounded">
        </div>

        <div class="mb-4">
            <label for="catch_probability" class="block text-sm font-medium text-gray-700">Persentase Peluang Tertangkap (%)</label>
            <input type="number" step="0.01" name="catch_probability" id="catch_probability" value="{{ old('catch_probability', $fish->catch_probability) }}" required class="mt-1 p-2 w-full border rounded">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" class="mt-1 p-2 w-full border rounded">{{ old('description', $fish->description) }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan Perubahan</button>
        <a href="{{ route('fishes.index') }}" class="ml-4 text-gray-600 hover:underline">Kembali</a>
    </form>
@endsection
