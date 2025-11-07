@extends('layouts.app')

@section('title', 'Add New Fish')

@section('content')
<div class="mb-4">
    <h2>Add New Fish</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('fishes.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fish Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rarity <span class="text-danger">*</span></label>
                    <select class="form-select @error('rarity') is-invalid @enderror" name="rarity" required>
                        <option value="">Select Rarity</option>
                        @foreach($rarities as $rarity)
                            <option value="{{ $rarity }}" {{ old('rarity') == $rarity ? 'selected' : '' }}>
                                {{ $rarity }}
                            </option>
                        @endforeach
                    </select>
                    @error('rarity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Min Weight (kg) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('base_weight_min') is-invalid @enderror"
                           name="base_weight_min" value="{{ old('base_weight_min') }}" required>
                    @error('base_weight_min') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Max Weight (kg) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('base_weight_max') is-invalid @enderror"
                           name="base_weight_max" value="{{ old('base_weight_max') }}" required>
                    @error('base_weight_max') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sell Price (per kg) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('sell_price_per_kg') is-invalid @enderror"
                           name="sell_price_per_kg" value="{{ old('sell_price_per_kg') }}" required>
                    @error('sell_price_per_kg') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Catch Probability (%) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('catch_probability') is-invalid @enderror"
                           name="catch_probability" value="{{ old('catch_probability') }}" required>
                    @error('catch_probability') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          name="description" rows="3">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Fish</button>
                <a href="{{ route('fishes.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection