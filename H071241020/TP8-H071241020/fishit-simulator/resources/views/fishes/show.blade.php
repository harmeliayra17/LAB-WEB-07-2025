@extends('layouts.app')
@section('content')
    <h1>Detail Ikan</h1>
    <p><strong>Nama:</strong> {{ $fish->name }}</p>
    <p><strong>Rarity:</strong> {{ $fish->rarity }}</p>
    <p><strong>Berat Minimum:</strong> {{ $fish->base_weight_min }} kg</p>
    <p><strong>Berat Maksimum:</strong> {{ $fish->base_weight_max }} kg</p>
    <p><strong>Harga per kg:</strong> {{ $fish->sell_price_per_kg }} Coins</p>
    <p><strong>Peluang Tertangkap:</strong> {{ $fish->catch_probability }}%</p>
    <p><strong>Deskripsi:</strong> {{ $fish->description ?? 'Tidak ada deskripsi' }}</p>
    <a href="{{ route('fishes.edit', $fish->id) }}">Edit</a>
    <form action="{{ route('fishes.destroy', $fish->id) }}" method="POST" style="display:inline;">
        @csrf @method('DELETE')
        <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
    </form>
    <a href="{{ route('fishes.index') }}">Kembali</a>
@endsection
