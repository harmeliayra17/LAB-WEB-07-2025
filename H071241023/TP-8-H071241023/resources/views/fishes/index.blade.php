@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-64px)] px-3 sm:px-5 lg:px-8 py-5 mt-8">

@php
    $rarityColors = [
        'Common'    => 'bg-gray-100 text-gray-700',
        'Uncommon'  => 'bg-green-200 text-green-900',
        'Rare'      => 'bg-blue-500 text-white',
        'Epic'      => 'bg-purple-500 text-white',
        'Legendary' => 'bg-orange-400 text-white',
        'Mythic'    => 'bg-red-500 text-white',
        'Secret'    => 'bg-teal-400 text-white',
    ];
    @endphp

    <div class="mx-auto max-w-6xl bg-white/30 backdrop-blur-lg border border-white/40 rounded-2xl shadow-xl p-4 sm:p-5">
        <div class="mb-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-white drop-shadow mb-2">Fish It! Database</h1>
            <form method="GET" action="{{ route('fishes.index') }}"
                class="flex flex-wrap items-center gap-2 lg:gap-3">

                <select name="rarity"
                    class="px-3 py-2 rounded-md border border-white/40 bg-white/60 text-gray-800 text-sm
                        focus:ring-1 focus:ring-violet-400 outline-none">
                    <option value="">-- Filter by Rarity --</option>
                    @foreach ($rarities as $r)
                        <option value="{{ $r }}" @selected(request('rarity') === $r)>{{ $r }}</option>
                    @endforeach
                </select>

                <input type="text" name="search" placeholder="Search by Name"
                    value="{{ request('search') }}"
                    class="px-3 py-2 rounded-md border border-white/40 bg-white/60 text-gray-800 text-sm
                            placeholder-gray-500 focus:ring-1 focus:ring-violet-400 outline-none">

                <select name="sort"
                    class="px-3 py-2 rounded-md border border-white/40 bg-white/60 text-gray-800 text-sm
                        focus:ring-1 focus:ring-violet-400 outline-none">
                    <option value="name" @selected(($sort ?? request('sort')) === 'name')>Sort: Name</option>
                    <option value="sell_price_per_kg" @selected(($sort ?? request('sort')) === 'sell_price_per_kg')>Sort: Harga per-Kg</option>
                    <option value="catch_probability" @selected(($sort ?? request('sort')) === 'catch_probability')>Sort: Probabilitas</option>
                </select>

                @php $currentOrder = $order ?? request('order', 'asc'); @endphp
                <select name="order"
                    class="px-3 py-2 rounded-md border border-white/40 bg-white/60 text-gray-800 text-sm
                        focus:ring-1 focus:ring-violet-400 outline-none">
                    <option value="asc"  @selected($currentOrder === 'asc')>A → Z / Kecil → Besar</option>
                    <option value="desc" @selected($currentOrder === 'desc')>Z → A / Besar → Kecil</option>
                </select>

                <button type="submit"
                    class="px-4 py-2 rounded-md bg-violet-500 hover:bg-violet-600 text-white text-sm font-medium shadow transition">
                    Apply
                </button>

                <a href="{{ route('fishes.index') }}"
                    class="px-4 py-2 rounded-md bg-gray-500/70 hover:bg-gray-600 text-white text-sm font-medium shadow transition text-center">
                    Reset
                </a>

                <div class="flex-1"></div>
                <a href="{{ route('fishes.create') }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-violet-500 hover:bg-violet-600 text-white font-semibold shadow-md transition text-sm sm:text-base">
                    + Tambah Ikan
                </a>
            </form>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/40">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-white/40">
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rarity</th>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Berat (Kg)</th>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga/Kg</th>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Probability (%)</th>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/40">
                    @forelse ($fishes as $fish)
                        <tr class="bg-white/70 hover:bg-white/80 transition">
                            <td class="px-3 sm:px-4 py-3 text-gray-800">{{ $fish->id }}</td>
                            <td class="px-3 sm:px-4 py-3 text-gray-800 font-medium">{{ $fish->name }}</td>
                            <td class="px-3 sm:px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold {{ $rarityColors[$fish->rarity] ?? 'bg-gray-200 text-gray-800' }}">
                                    {{ $fish->rarity }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 text-gray-800">{{ $fish->weight_range_formatted }}</td>
                            <td class="px-3 sm:px-4 py-3 text-gray-800">{{ $fish->sell_price_per_kg_formatted }}</td>
                            <td class="px-3 sm:px-4 py-3 text-gray-800">{{ $fish->catch_probability_formatted }}</td>
                            <td class="px-3 sm:px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <a href="{{ route('fishes.show', $fish) }}"
                                        class="px-3 py-1.5 rounded-md bg-sky-500 hover:bg-sky-600 text-white text-sm font-medium shadow transition">
                                        Lihat
                                    </a>
                                    <a href="{{ route('fishes.edit', $fish) }}"
                                        class="px-3 py-1.5 rounded-md bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium shadow transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('fishes.destroy', $fish) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus ikan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-md bg-rose-500 hover:bg-rose-600 text-white text-sm font-medium shadow transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white/70">
                            <td colspan="7" class="px-4 py-6 text-center text-gray-700">No fishes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $fishes->withQueryString()->links() }}
        </div>
    </div>
    </div>
    @endsection