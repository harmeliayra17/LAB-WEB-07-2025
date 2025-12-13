@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-semibold text-purple-200 mb-6">Dashboard</h2>

<div class="grid md:grid-cols-3 gap-6">
    <div class="p-5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-sm flex flex-col justify-between">
        <div>
            <h3 class="text-purple-300 text-sm">Total Kategori</h3>
            <p class="text-3xl font-bold text-white mt-1">
                {{ \App\Models\Category::count() }}
            </p>
        </div>
        <a href="{{ route('categories.index') }}"
            class="mt-4 py-2 w-full text-center rounded-lg bg-purple-500/70 hover:bg-purple-500/90 text-white transition">
            Lihat Kategori
        </a>
    </div>

    <div class="p-5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-sm flex flex-col justify-between">
        <div>
            <h3 class="text-purple-300 text-sm">Total Produk</h3>
            <p class="text-3xl font-bold text-white mt-1">
                {{ \App\Models\Product::count() }}
            </p>
        </div>
        <a href="{{ route('products.index') }}"
            class="mt-4 py-2 w-full text-center rounded-lg bg-purple-500/70 hover:bg-purple-500/90 text-white transition">
            Lihat Produk
        </a>
    </div>

    <div class="p-5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-sm flex flex-col justify-between">
        <div>
            <h3 class="text-purple-300 text-sm">Total Warehouse</h3>
            <p class="text-3xl font-bold text-white mt-1">
                {{ \App\Models\Warehouse::count() }}
            </p>
        </div>
        <a href="{{ route('warehouses.index') }}"
            class="mt-4 py-2 w-full text-center rounded-lg bg-purple-500/70 hover:bg-purple-500/90 text-white transition">
            Lihat Warehouse
        </a>
    </div>
</div>
@endsection