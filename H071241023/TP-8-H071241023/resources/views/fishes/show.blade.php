@extends('layouts.app')

@section('title', 'Detail Ikan')

@section('content')
<div class="min-h-[calc(100vh-64px)] px-4 sm:px-6 lg:px-8 py-6">

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

    <div class="mx-auto max-w-4xl bg-white/30 backdrop-blur-lg border border-white/40 rounded-2xl shadow-xl">
        <div class="flex items-center justify-between gap-3 px-6 pt-6">
            <h1 class="text-2xl font-semibold text-white drop-shadow">Detail Ikan</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('fishes.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-500/70 hover:bg-gray-600 text-white text-sm font-medium shadow transition">
                    < Kembali
                </a>
                <a href="{{ route('fishes.edit', $fish) }}"
                    class="px-4 py-2 rounded-lg bg-violet-500 hover:bg-violet-600 text-white text-sm font-semibold shadow transition">
                    Edit
                </a>
                <form action="{{ route('fishes.destroy', $fish) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus ikan ini?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold shadow transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="px-6 pb-6 pt-4">
            <div class="mb-4">
                <span class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs font-semibold {{ $rarityColors[$fish->rarity] ?? 'bg-gray-200 text-gray-800' }}">
                    {{ $fish->rarity }}
                </span>
            </div>

            <div class="rounded-xl overflow-hidden border border-white/40">
                <table class="min-w-full divide-y divide-white/40">
                    <tr class="bg-white/70"><th class="w-40 px-4 py-3 text-left text-gray-600">ID</th><td class="px-4 py-3 text-gray-900">{{ $fish->id }}</td></tr>
                    <tr class="bg-white/70"><th class="px-4 py-3 text-left text-gray-600">Name</th><td class="px-4 py-3 text-gray-900 font-medium">{{ $fish->name }}</td></tr>
                    <tr class="bg-white/70"><th class="px-4 py-3 text-left text-gray-600">Berat</th><td class="px-4 py-3 text-gray-900">{{ $fish->weight_range_formatted }}</td></tr>
                    <tr class="bg-white/70"><th class="px-4 py-3 text-left text-gray-600">Harga/kg</th><td class="px-4 py-3 text-gray-900">{{ $fish->sell_price_per_kg_formatted }}</td></tr>
                    <tr class="bg-white/70"><th class="px-4 py-3 text-left text-gray-600">Probabilitas</th><td class="px-4 py-3 text-gray-900">{{ $fish->catch_probability_formatted }}</td></tr>
                    <tr class="bg-white/70"><th class="px-4 py-3 text-left text-gray-600">Dibuat</th><td class="px-4 py-3 text-gray-900">{{ optional($fish->created_at)->format('d M Y H:i') }}</td></tr>
                    <tr class="bg-white/70"><th class="px-4 py-3 text-left text-gray-600">Diupdate</th><td class="px-4 py-3 text-gray-900">{{ optional($fish->updated_at)->format('d M Y H:i') }}</td></tr>
                    @if ($fish->description)
                        <tr class="bg-white/70">
                            <th class="px-4 py-3 text-left text-gray-600 align-top">Deskripsi</th>
                            <td class="px-4 py-3 text-gray-900">{{ $fish->description }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
 @endsection