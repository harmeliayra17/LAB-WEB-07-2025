@extends('layouts.app')

@section('title', 'Edit Ikan - Fish It Simulator')

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #1a237e;
    }

    .form-label .required {
        color: #c62828;
    }

    .form-control {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #1a237e;
    }

    .form-control.error {
        border-color: #c62828;
    }

    .error-message {
        color: #c62828;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .form-hint {
        font-size: 0.85rem;
        color: #666;
        margin-top: 0.3rem;
    }

    @media (max-width: 768px) 
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title"> Edit Ikan: {{ $fish->name }}</h1>
    </div>

    <form action="{{ route('fishes.update', $fish->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label">Nama Ikan <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-control @error('name') error @enderror" 
                   value="{{ old('name', $fish->name) }}" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="rarity" class="form-label">Rarity <span class="required">*</span></label>
            <select id="rarity" name="rarity" class="form-control @error('rarity') error @enderror" required>
                <option value="">-- Pilih Rarity --</option>
                <option value="Common" {{ old('rarity', $fish->rarity) == 'Common' ? 'selected' : '' }}>Common</option>
                <option value="Uncommon" {{ old('rarity', $fish->rarity) == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                <option value="Rare" {{ old('rarity', $fish->rarity) == 'Rare' ? 'selected' : '' }}>Rare</option>
                <option value="Epic" {{ old('rarity', $fish->rarity) == 'Epic' ? 'selected' : '' }}>Epic</option>
                <option value="Legendary" {{ old('rarity', $fish->rarity) == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                <option value="Mythic" {{ old('rarity', $fish->rarity) == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                <option value="Secret" {{ old('rarity', $fish->rarity) == 'Secret' ? 'selected' : '' }}>Secret</option>
            </select>
            @error('rarity')
                <div class="error-message">{{ $message }}</div>*%
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="base_weight_min" class="form-label">Berat Minimum (kg) <span class="required">*</span></label>
                <input type="number" id="base_weight_min" name="base_weight_min" step="0.01" 
                       class="form-control @error('base_weight_min') error @enderror" 
                       value="{{ old('base_weight_min', $fish->base_weight_min) }}" required>
                @error('base_weight_min')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="base_weight_max" class="form-label">Berat Maksimum (kg) <span class="required">*</span></label>
                <input type="number" id="base_weight_max" name="base_weight_max" step="0.01" 
                       class="form-control @error('base_weight_max') error @enderror" 
                       value="{{ old('base_weight_max', $fish->base_weight_max) }}" required>
                @error('base_weight_max')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="form-hint">Harus lebih besar dari berat minimum</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="sell_price_per_kg" class="form-label">Harga Jual per kg (Coins) <span class="required">*</span></label>
                <input type="number" id="sell_price_per_kg" name="sell_price_per_kg" 
                       class="form-control @error('sell_price_per_kg') error @enderror" 
                       value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}" required>
                @error('sell_price_per_kg')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="catch_probability" class="form-label">Peluang Tertangkap (%) <span class="required">*</span></label>
                <input type="number" id="catch_probability" name="catch_probability" step="0.01" 
                       class="form-control @error('catch_probability') error @enderror" 
                       value="{{ old('catch_probability', $fish->catch_probability) }}" required>
                @error('catch_probability')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="form-hint">Nilai antara 0.01% - 100.00%</div>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea id="description" name="description" rows="5" 
                      class="form-control @error('description') error @enderror">{{ old('description', $fish->description) }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="form-hint">Opsional - Tambahkan deskripsi atau informasi tambahan tentang ikan</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Update Ikan</button>
            <a href="{{ route('fishes.show', $fish->id) }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </form>
</div>
@endsection