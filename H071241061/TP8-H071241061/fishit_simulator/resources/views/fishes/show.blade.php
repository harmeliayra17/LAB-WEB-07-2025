@extends('layouts.app')

@section('title', 'Detail Ikan - ' . $fish->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <!-- Back Button -->
    <a href="{{ route('fishes.index') }}" 
       class="inline-flex items-center space-x-2 px-5 py-2 bg-white/10 border border-white/20 backdrop-blur-md text-white rounded-lg hover:bg-white/20 transition-all shadow-glow">
        <span>⬅️</span>
        <span>Kembali ke Database</span>
    </a>

    <!-- Fish Header -->
    <div class="glass-card rounded-3xl shadow-ocean border border-white/10 text-center p-10 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 via-blue-500/10 to-purple-500/10 blur-2xl"></div>
        <div class="relative z-10">
            <div class="text-8xl mb-4 drop-shadow-lg">{{ $fish->rarity_icon }}</div>
            <h1 class="text-4xl font-extrabold text-white tracking-wide">{{ $fish->name }}</h1>
            <div class="flex justify-center mt-3">
                <span class="px-6 py-2 text-sm font-bold text-white rounded-full {{ $fish->rarity_color }} shadow-md">
                    ✨ {{ $fish->rarity }}
                </span>
            </div>
            <p class="text-cyan-200 mt-2 text-sm">ID: #{{ $fish->id }}</p>
        </div>
    </div>

    <!-- Detail Info -->
    <div class="glass-card rounded-2xl shadow-lg border border-white/10 backdrop-blur-lg p-8 space-y-5 text-white">
        <h2 class="text-2xl font-bold mb-4 flex items-center">
            <span class="mr-2">📊</span> Informasi Detail
        </h2>

        <!-- Berat -->
        <div class="flex items-center justify-between p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-all">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">⚖️</span>
                <div>
                    <p class="text-sm text-cyan-200">Rentang Berat</p>
                    <p class="text-lg font-semibold">{{ $fish->formatted_weight_range }}</p>
                </div>
            </div>
        </div>

        <!-- Harga -->
        <div class="flex items-center justify-between p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-all">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">💰</span>
                <div>
                    <p class="text-sm text-cyan-200">Harga Jual per Kg</p>
                    <p class="text-lg font-semibold text-yellow-300">{{ $fish->formatted_price }}</p>
                </div>
            </div>
        </div>

        <!-- Peluang Tangkap -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-all">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">🎣</span>
                <div>
                    <p class="text-sm text-cyan-200">Peluang Tertangkap</p>
                    <p class="text-lg font-semibold text-green-300">{{ $fish->formatted_probability }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/3">
                <div class="bg-white/10 h-3 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-400 to-green-600 rounded-full transition-all" 
                         style="width: {{ min($fish->catch_probability, 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        @if($fish->description)
        <div class="p-5 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all">
            <div class="flex items-start space-x-3">
                <span class="text-2xl">📝</span>
                <div>
                    <p class="text-sm text-cyan-200">Deskripsi</p>
                    <p class="text-white/90 leading-relaxed">{{ $fish->description }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Timestamps -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-white/10">
            <div class="flex items-center space-x-3">
                <span class="text-xl">📅</span>
                <div>
                    <p class="text-xs text-cyan-300">Dibuat pada</p>
                    <p class="text-sm font-semibold">{{ $fish->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-xl">🔄</span>
                <div>
                    <p class="text-xs text-cyan-300">Terakhir diupdate</p>
                    <p class="text-sm font-semibold">{{ $fish->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="glass-card rounded-2xl p-8 shadow-glow border border-white/10 text-white">
        <h2 class="text-2xl font-bold mb-4 flex items-center">
            <span class="mr-2">📈</span> Statistik Perhitungan
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-md hover:bg-white/20 transition-all">
                <p class="text-sm text-cyan-200 mb-1">Nilai Maksimal</p>
                <p class="text-2xl font-bold text-cyan-300">
                    {{ number_format($fish->base_weight_max * $fish->sell_price_per_kg, 0, ',', '.') }} Coins
                </p>
                <p class="text-xs text-cyan-400 mt-1">Jika berat maksimal</p>
            </div>

            <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-md hover:bg-white/20 transition-all">
                <p class="text-sm text-cyan-200 mb-1">Nilai Minimal</p>
                <p class="text-2xl font-bold text-green-300">
                    {{ number_format($fish->base_weight_min * $fish->sell_price_per_kg, 0, ',', '.') }} Coins
                </p>
                <p class="text-xs text-cyan-400 mt-1">Jika berat minimal</p>
            </div>

            <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-md hover:bg-white/20 transition-all">
                <p class="text-sm text-cyan-200 mb-1">Nilai Rata-rata</p>
                <p class="text-2xl font-bold text-yellow-300">
                    {{ number_format((($fish->base_weight_max + $fish->base_weight_min) / 2) * $fish->sell_price_per_kg, 0, ',', '.') }} Coins
                </p>
                <p class="text-xs text-cyan-400 mt-1">Estimasi tengah</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col md:flex-row gap-4">
        <a href="{{ route('fishes.edit', $fish) }}" 
           class="flex-1 py-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all text-center font-bold text-lg flex items-center justify-center space-x-2">
            <span>✏️</span>
            <span>Edit Ikan</span>
        </a>
        
        <form method="POST" action="{{ route('fishes.destroy', $fish) }}" class="flex-1">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('⚠️ Apakah Anda yakin ingin menghapus ikan {{ $fish->name }}? Data yang dihapus tidak dapat dikembalikan!')"
                    class="w-full py-4 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all font-bold text-lg flex items-center justify-center space-x-2">
                <span>🗑️</span>
                <span>Hapus Ikan</span>
            </button>
        </form>
    </div>

    <!-- Fun Fact -->
    <div class="glass-card bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-pink-500/20 rounded-2xl border border-white/10 backdrop-blur-md p-6 text-white shadow-ocean">
        <div class="flex items-center space-x-3 mb-3">
            <span class="text-3xl">💡</span>
            <h3 class="text-xl font-bold">Fun Fact!</h3>
        </div>
        <p class="text-sm leading-relaxed text-cyan-100">
            Ikan <strong class="text-white">{{ $fish->name }}</strong> memiliki rarity 
            <strong class="text-yellow-300">{{ $fish->rarity }}</strong> dengan peluang tertangkap 
            <strong class="text-green-300">{{ $fish->formatted_probability }}</strong>. 
            @if($fish->catch_probability < 1)
                Ikan ini sangat langka! Kamu butuh keberuntungan luar biasa untuk menangkapnya! 🍀
            @elseif($fish->catch_probability < 10)
                Ikan ini cukup langka. Terus memancing dan kamu akan berhasil! 🎣
            @elseif($fish->catch_probability < 50)
                Ikan ini memiliki peluang menengah. Kesabaran adalah kunci! ⏰
            @else
                Ikan ini cukup umum. Kamu bisa menangkapnya dengan mudah! 😊
            @endif
        </p>
    </div>
</div>
@endsection
