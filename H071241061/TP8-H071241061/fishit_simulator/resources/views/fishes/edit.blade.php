@extends('layouts.app')

@section('title', 'Edit Ikan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6 mb-8 shadow-ocean border border-white/10">
        <div class="flex items-center space-x-3">
            <span class="text-4xl">✏️</span>
            <div>
                <h2 class="text-3xl font-bold gradient-text">Edit Ikan</h2>
                <p class="text-cyan-200 text-sm">Ubah data ikan: <strong class="text-white">{{ $fish->name }}</strong></p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('fishes.update', $fish) }}" 
          class="glass-card rounded-2xl p-8 shadow-glow border border-white/10 text-white">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Nama Ikan -->
            <div>
                <label class="block text-sm font-bold text-cyan-200 mb-2">
                    🐟 Nama Ikan <span class="text-pink-400">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $fish->name) }}"
                       placeholder="Contoh: Golden Tuna"
                       class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 placeholder-gray-400 text-white focus:ring-2 focus:ring-cyan-400 focus:outline-none transition-all @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rarity -->
            <div>
                <label class="block text-sm font-bold text-cyan-200 mb-2">
                    ✨ Rarity <span class="text-pink-400">*</span>
                </label>
                <select name="rarity" 
                        class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-cyan-400 focus:outline-none transition-all @error('rarity') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Rarity</option>
                    @foreach($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ old('rarity', $fish->rarity) == $rarity ? 'selected' : '' }}>
                            {{ $rarity }}
                        </option>
                    @endforeach
                </select>
                @error('rarity')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-3 flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-green-500/60 text-white text-xs rounded-full backdrop-blur-md">Common 🐟</span>
                    <span class="px-3 py-1 bg-blue-500/60 text-white text-xs rounded-full backdrop-blur-md">Uncommon 🐠</span>
                    <span class="px-3 py-1 bg-purple-500/60 text-white text-xs rounded-full backdrop-blur-md">Rare 🐡</span>
                    <span class="px-3 py-1 bg-pink-500/60 text-white text-xs rounded-full backdrop-blur-md">Epic 🦈</span>
                    <span class="px-3 py-1 bg-yellow-400/70 text-white text-xs rounded-full backdrop-blur-md">Legendary 🐋</span>
                    <span class="px-3 py-1 bg-red-500/60 text-white text-xs rounded-full backdrop-blur-md">Mythic 🦑</span>
                    <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs rounded-full backdrop-blur-md">Secret 🐉</span>
                </div>
            </div>

            <!-- Berat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-cyan-200 mb-2">
                        ⚖️ Berat Minimum (kg) <span class="text-pink-400">*</span>
                    </label>
                    <input type="number" 
                           name="base_weight_min" 
                           value="{{ old('base_weight_min', $fish->base_weight_min) }}"
                           step="0.01" min="0.01" placeholder="0.50"
                           class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-cyan-400 focus:outline-none transition-all @error('base_weight_min') border-red-500 @enderror"
                           required>
                    @error('base_weight_min')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-cyan-200 mb-2">
                        ⚖️ Berat Maksimum (kg) <span class="text-pink-400">*</span>
                    </label>
                    <input type="number" 
                           name="base_weight_max" 
                           value="{{ old('base_weight_max', $fish->base_weight_max) }}"
                           step="0.01" min="0.01" placeholder="5.00"
                           class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-cyan-400 focus:outline-none transition-all @error('base_weight_max') border-red-500 @enderror"
                           required>
                    @error('base_weight_max')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Harga Jual -->
            <div>
                <label class="block text-sm font-bold text-cyan-200 mb-2">
                    💰 Harga Jual per Kg (Coins) <span class="text-pink-400">*</span>
                </label>
                <input type="number" 
                       name="sell_price_per_kg" 
                       value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}"
                       min="0" placeholder="1000"
                       class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-cyan-400 focus:outline-none transition-all @error('sell_price_per_kg') border-red-500 @enderror"
                       required>
                @error('sell_price_per_kg')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Peluang Tangkap -->
            <div>
                <label class="block text-sm font-bold text-cyan-200 mb-2">
                    🎣 Peluang Tertangkap (%) <span class="text-pink-400">*</span>
                </label>
                <input type="number" 
                       name="catch_probability" 
                       value="{{ old('catch_probability', $fish->catch_probability) }}"
                       step="0.01" min="0.01" max="100" placeholder="50.00"
                       class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-cyan-400 focus:outline-none transition-all @error('catch_probability') border-red-500 @enderror"
                       required>
                @error('catch_probability')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-cyan-300 mt-1">Nilai antara 0.01% - 100%</p>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-bold text-cyan-200 mb-2">
                    📝 Deskripsi (Opsional)
                </label>
                <textarea name="description" rows="4" placeholder="Masukkan deskripsi ikan..."
                          class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-cyan-400 focus:outline-none transition-all @error('description') border-red-500 @enderror">{{ old('description', $fish->description) }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 mt-10">
            <button type="submit" 
                    class="flex-1 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-lg hover:shadow-glow transform hover:scale-105 transition-all font-bold text-lg">
                ✅ Update Ikan
            </button>
            <a href="{{ route('fishes.show', $fish) }}" 
               class="flex-1 py-3 bg-white/10 text-white rounded-lg border border-white/20 hover:bg-white/20 hover:shadow-ocean transition-all text-center font-bold text-lg">
                ❌ Batal
            </a>
        </div>
    </form>

    <!-- Current Data Info -->
    <div class="glass-card border-l-4 border-yellow-400 rounded-xl p-5 mt-8 shadow-glow text-cyan-100">
        <div class="flex items-start space-x-3">
            <span class="text-2xl">ℹ️</span>
            <div>
                <h4 class="font-bold text-yellow-300 mb-1">Data Saat Ini</h4>
                <ul class="text-sm text-cyan-200 space-y-1">
                    <li>• <strong>ID:</strong> #{{ $fish->id }}</li>
                    <li>• <strong>Dibuat:</strong> {{ $fish->created_at->format('d M Y, H:i') }}</li>
                    <li>• <strong>Terakhir diupdate:</strong> {{ $fish->updated_at->format('d M Y, H:i') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
