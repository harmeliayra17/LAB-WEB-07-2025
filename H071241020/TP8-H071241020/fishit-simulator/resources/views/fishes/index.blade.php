@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Daftar Ikan</h1>

    <!-- Filter Rarity -->
    <form method="GET" action="{{ route('fishes.index') }}" class="mb-4">
        <label for="rarity" class="mr-2">Filter berdasarkan Rarity:</label>
        <select name="rarity" id="rarity" onchange="this.form.submit()" class="border p-2 rounded">
            <option value="">Semua</option>
            <option value="Common" {{ request('rarity') == 'Common' ? 'selected' : '' }}>Common</option>
            <option value="Uncommon" {{ request('rarity') == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
            <option value="Rare" {{ request('rarity') == 'Rare' ? 'selected' : '' }}>Rare</option>
            <option value="Epic" {{ request('rarity') == 'Epic' ? 'selected' : '' }}>Epic</option>
            <option value="Legendary" {{ request('rarity') == 'Legendary' ? 'selected' : '' }}>Legendary</option>
            <option value="Mythic" {{ request('rarity') == 'Mythic' ? 'selected' : '' }}>Mythic</option>
            <option value="Secret" {{ request('rarity') == 'Secret' ? 'selected' : '' }}>Secret</option>
        </select>
    </form>

    <!-- Tombol Tambah Ikan -->
    <a href="{{ route('fishes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">Tambah Ikan</a>

    @if ($fishes->isEmpty())
        <p class="text-gray-600">Tidak ada data ikan.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Nama</th>
                        <th class="p-3 border-b">Rarity</th>
                        <th class="p-3 border-b">Berat Min (kg)</th>
                        <th class="p-3 border-b">Berat Max (kg)</th>
                        <th class="p-3 border-b">Harga per kg (Coins)</th>
                        <th class="p-3 border-b">Peluang Tertangkap (%)</th>
                        <th class="p-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fishes as $fish)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b">{{ $fish->id }}</td>
                            <td class="p-3 border-b">{{ $fish->name }}</td>
                            <td class="p-3 border-b">{{ $fish->rarity }}</td>
                            <td class="p-3 border-b">{{ $fish->base_weight_min }}</td>
                            <td class="p-3 border-b">{{ $fish->base_weight_max }}</td>
                            <td class="p-3 border-b">{{ $fish->sell_price_per_kg }}</td>
                            <td class="p-3 border-b">{{ $fish->catch_probability }}</td>
                            <td class="p-3 border-b">
                                <a href="{{ route('fishes.show', $fish->id) }}" class="text-blue-500 hover:underline mr-2">Lihat Detail</a>
                                <a href="{{ route('fishes.edit', $fish->id) }}" class="text-yellow-500 hover:underline mr-2">Edit</a>
                                <form action="{{ route('fishes.destroy', $fish->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $fishes->links('pagination::tailwind') }}
        </div>
    @endif
@endsection
