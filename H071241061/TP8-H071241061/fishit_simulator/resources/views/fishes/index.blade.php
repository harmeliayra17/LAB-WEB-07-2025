@extends('layouts.app')

@section('title', 'Fish Database')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="glass-card rounded-3xl border border-white/10 backdrop-blur-xl shadow-ocean p-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 via-blue-500/10 to-purple-600/10 blur-2xl"></div>
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h2 class="text-4xl font-extrabold text-white drop-shadow-md">🐠 Fish Database</h2>
                <p class="text-cyan-200 mt-2">Kelola semua data ikan Fish It Roblox 🪸</p>
            </div>
            <a href="{{ route('fishes.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-cyan-400 to-sky-600 text-white rounded-xl hover:shadow-xl hover:scale-105 transition-all flex items-center gap-2 font-semibold">
                <span>➕</span> <span>Tambah Ikan</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="glass-card rounded-2xl border border-white/10 backdrop-blur-xl p-6 shadow-lg">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 text-white">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-cyan-200 mb-2">🔍 Cari Ikan</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama atau deskripsi..."
                       class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 placeholder-white/50 focus:ring-2 focus:ring-cyan-400 outline-none">
            </div>

            <!-- Filter Rarity -->
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-2">✨ Filter Rarity</label>
                <select name="rarity" 
                        class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-cyan-400 outline-none">
                    <option value="">Semua Rarity</option>
                    @foreach($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                            {{ $rarity }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-2">📊 Urutkan</label>
                <select name="sort_by" 
                        onchange="this.form.submit()"
                        class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-cyan-400 outline-none">
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                    <option value="sell_price_per_kg" {{ request('sort_by') == 'sell_price_per_kg' ? 'selected' : '' }}>Harga</option>
                    <option value="catch_probability" {{ request('sort_by') == 'catch_probability' ? 'selected' : '' }}>Probabilitas</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex gap-3 mt-2">
                <button type="submit" 
                        class="flex items-center gap-2 px-6 py-2 bg-cyan-500/80 hover:bg-cyan-400 text-white rounded-lg font-semibold transition-all shadow-lg">
                    🔍 <span>Cari</span>
                </button>
                <a href="{{ route('fishes.index') }}" 
                   class="flex items-center gap-2 px-6 py-2 bg-gray-400/70 hover:bg-gray-300 text-white rounded-lg font-semibold transition-all shadow-lg">
                    🔄 <span>Reset</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Fish Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($fishes as $fish)
        <div class="glass-card rounded-2xl overflow-hidden border border-white/10 backdrop-blur-xl shadow-lg hover:shadow-glow hover:scale-[1.02] transition-all duration-300 {{ 
            $fish->rarity == 'Common' ? 'border-green-400/60' :
            ($fish->rarity == 'Uncommon' ? 'border-sky-400/60' :
            ($fish->rarity == 'Rare' ? 'border-indigo-400/60' :
            ($fish->rarity == 'Epic' ? 'border-pink-400/60' :
            ($fish->rarity == 'Legendary' ? 'border-yellow-400/60' :
            ($fish->rarity == 'Mythic' ? 'border-red-400/60' : 'border-purple-400/60')))))
        }}">

            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-900/60 via-sky-800/40 to-purple-800/60 p-5">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-2">
                        <span class="text-4xl">{{ $fish->rarity_icon }}</span>
                        <div>
                            <h3 class="font-bold text-lg text-white">{{ $fish->name }}</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full text-white {{ $fish->rarity_color }}">
                                {{ $fish->rarity }}
                            </span>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-cyan-200/70">#{{ $fish->id }}</span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-3 text-white/90">
                <div class="flex items-center justify-between bg-white/10 p-3 rounded-lg">
                    <span class="text-sm">⚖️ Berat</span>
                    <span class="text-sm font-semibold text-cyan-300">{{ $fish->formatted_weight_range }}</span>
                </div>
                <div class="flex items-center justify-between bg-white/10 p-3 rounded-lg">
                    <span class="text-sm">💰 Harga</span>
                    <span class="text-sm font-semibold text-yellow-300">{{ $fish->formatted_price }}</span>
                </div>
                <div class="flex items-center justify-between bg-white/10 p-3 rounded-lg">
                    <span class="text-sm">🎣 Peluang</span>
                    <span class="text-sm font-semibold text-green-300">{{ $fish->formatted_probability }}</span>
                </div>

                @if($fish->description)
                <div class="bg-white/10 p-3 rounded-lg text-xs text-white/80 line-clamp-2">
                    {{ $fish->description }}
                </div>
                @endif
            </div>

            <!-- Card Footer -->
            <div class="bg-white/10 border-t border-white/10 p-4 flex gap-2">
                <a href="{{ route('fishes.show', $fish) }}" 
                   class="flex-1 py-2 bg-sky-500/80 hover:bg-sky-400 text-white rounded-lg transition-all text-center text-sm font-semibold">
                    👁️ Detail
                </a>
                <a href="{{ route('fishes.edit', $fish) }}" 
                   class="flex-1 py-2 bg-yellow-500/80 hover:bg-yellow-400 text-white rounded-lg transition-all text-center text-sm font-semibold">
                    ✏️ Edit
                </a>
                <form method="POST" action="{{ route('fishes.destroy', $fish) }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('⚠️ Yakin ingin menghapus ikan {{ $fish->name }}?')"
                            class="w-full py-2 bg-red-500/80 hover:bg-red-400 text-white rounded-lg transition-all text-sm font-semibold">
                        🗑️ Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="md:col-span-3 text-center py-12 text-white/90">
            <div class="text-6xl mb-4">🐟</div>
            <h3 class="text-2xl font-bold mb-2">Tidak ada ikan ditemukan</h3>
            <p class="text-cyan-200">Coba ubah filter atau tambahkan ikan baru</p>
            <a href="{{ route('fishes.create') }}" 
               class="inline-block mt-4 px-6 py-3 bg-cyan-500 hover:bg-cyan-400 text-white rounded-xl transition-all font-semibold">
                ➕ Tambah Ikan Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($fishes->hasPages())
    <div class="glass-card border border-white/10 backdrop-blur-lg rounded-2xl p-4 shadow-inner text-white">
        {{ $fishes->links() }}
    </div>
    @endif
</div>
@endsection
