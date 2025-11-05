<div class="min-h-[calc(100vh-64px)] flex items-center justify-center relative">
    <form 
        method="POST"
        action="{{ isset($fish) && $fish->exists ? route('fishes.update', $fish->id) : route('fishes.store') }}"
        class="relative z-10 w-full max-w-lg p-6 sm:p-7 bg-white/30 backdrop-blur-lg border border-white/40 rounded-2xl shadow-xl mx-4">

        @csrf
        @if(isset($fish) && $fish->exists)
            @method('PUT')
        @endif

        @php($fish = $fish ?? null)
        <h2 class="text-xl sm:text-2xl font-semibold text-center mb-4 text-white drop-shadow-lg">
            {{ isset($fish) && $fish->exists ? 'Edit Data Ikan' : 'Tambah Data Ikan' }}
        </h2>

        <div class="mb-3">
            <label for="name" class="block text-white font-medium mb-1">Nama Ikan</label>
            <input id="name" type="text" name="name" value="{{ old('name', $fish->name ?? '') }}" required
                class="w-full p-2.5 rounded-lg border border-white/50 bg-white/70 text-gray-800 placeholder:text-gray-500
                    focus:ring-2 focus:ring-violet-400 outline-none"
                placeholder="Masukkan nama ikan">
        </div>

        <div class="mb-3">
            <label for="rarity" class="block text-white font-medium mb-1">Rarity</label>
            <select id="rarity" name="rarity" required
                class="w-full p-2.5 rounded-lg border border-white/50 bg-white/70 text-gray-800
                    focus:ring-2 focus:ring-violet-400 outline-none">
                <option value="">-- Pilih rarity --</option>
                @foreach (['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
                    <option value="{{ $r }}" @selected(old('rarity', $fish->rarity ?? '') === $r)>{{ $r }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
                <label for="base_weight_min" class="block text-white font-medium mb-1">Berat Min (kg)</label>
                <input id="base_weight_min" type="number" step="0.01" name="base_weight_min" 
                    value="{{ old('base_weight_min', $fish->base_weight_min ?? '') }}" required
                    class="w-full p-2.5 rounded-lg border border-white/50 bg-white/70 text-gray-800
                        focus:ring-2 focus:ring-violet-400 outline-none"
                    placeholder="ex: 1.50">
            </div>

            <div>
                <label for="base_weight_max" class="block text-white font-medium mb-1">Berat Maks (kg)</label>
                <input id="base_weight_max" type="number" step="0.01" name="base_weight_max"
                    value="{{ old('base_weight_max', $fish->base_weight_max ?? '') }}" required
                    class="w-full p-2.5 rounded-lg border border-white/50 bg-white/70 text-gray-800
                        focus:ring-2 focus:ring-violet-400 outline-none"
                    placeholder="mis. 3.20">
                @error('base_weight_max')
                    <p class="text-xs text-red-800 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="sell_price_per_kg" class="block text-white font-medium mb-1">Harga Jual per Kg</label>
            <input id="sell_price_per_kg" type="number" name="sell_price_per_kg"
                value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg ?? '') }}" required
                class="w-full p-2.5 rounded-lg border border-white/50 bg-white/70 text-gray-800
                    focus:ring-2 focus:ring-violet-400 outline-none"
                placeholder="ex: 50000">
        </div>

        <div class="mb-3">
            <label for="catch_probability" class="block text-white font-medium mb-1">Peluang Tertangkap (%)</label>
            <input id="catch_probability" type="number" step="0.01" name="catch_probability"
                value="{{ old('catch_probability', $fish->catch_probability ?? '') }}" required
                class="w-full p-2.5 rounded-lg border border-white/50 bg-white/70 text-gray-800
                    focus:ring-2 focus:ring-violet-400 outline-none"
                placeholder="ex. 0.75">
        </div>

        <div class="mb-5">
            <label for="description" class="block text-white font-medium mb-1">Deskripsi (opsional)</label>
            <textarea id="description" name="description" rows="3"
                    class="w-full p-2.5 rounded-lg border border-white/50 bg-white/70 text-gray-800
                        focus:ring-2 focus:ring-violet-400 outline-none"
                    placeholder="Catatan singkat tentang ikan">{{ old('description', $fish->description ?? '') }}</textarea>
        </div>

        <div class="flex items-center justify-between gap-2">
            <a href="{{ route('fishes.index') }}"
                class="px-4 py-2.5 bg-gray-500/70 hover:bg-gray-600 text-white rounded-lg shadow transition">
                Batal
            </a>

            <button type="submit"
                class="px-5 py-2.5 bg-violet-500 hover:bg-violet-600 text-white font-semibold rounded-lg shadow-md transition">
                {{ isset($fish) && $fish->exists ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>