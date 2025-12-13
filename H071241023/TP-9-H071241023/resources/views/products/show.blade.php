@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold text-purple-200 mb-4">Detail Produk</h2>

<div class="overflow-hidden rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm mb-6">
  <table class="min-w-full text-sm text-gray-100">
    <tbody class="[&>tr:nth-child(even)]:bg-white/5">
      <tr>
        <td class="px-4 py-3 text-gray-300 w-40">Nama</td>
        <td class="px-4 py-3">{{ $product->name }}</td>
      </tr>
      <tr>
        <td class="px-4 py-3 text-gray-300">Kategori</td>
        <td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
      </tr>
      <tr>
        <td class="px-4 py-3 text-gray-300">Harga</td>
        <td class="px-4 py-3">{{ number_format($product->price,0,',','.') }}</td>
      </tr>
      <tr>
        <td class="px-4 py-3 text-gray-300">Deskripsi</td>
        <td class="px-4 py-3">{{ $product->detail->description ?? '-' }}</td>
      </tr>
      <tr>
        <td class="px-4 py-3 text-gray-300">Berat</td>
        <td class="px-4 py-3">{{ $product->detail->weight ?? '-' }}</td>
      </tr>
      <tr>
        <td class="px-4 py-3 text-gray-300">Ukuran</td>
        <td class="px-4 py-3">{{ $product->detail->size ?? '-' }}</td>
      </tr>
    </tbody>
  </table>
</div>

<h3 class="text-lg font-semibold text-purple-200 mb-3">Stok per Warehouse</h3>
<div class="overflow-hidden rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm">
  <table class="min-w-full text-sm">
    <thead class="bg-purple-500/20 text-purple-100">
      <tr>
        <th class="text-left px-4 py-3">Warehouse</th>
        <th class="text-left px-4 py-3">Qty</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-white/10">
      @forelse($product->warehouses as $warehouse)
        <tr class="hover:bg-white/5">
          <td class="px-4 py-3">{{ $warehouse->name }}</td>
          <td class="px-4 py-3">{{ $warehouse->pivot->quantity }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="2" class="px-4 py-4 text-center text-gray-300">Belum ada stok</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<p class="mt-4">
  <a href="{{ route('products.index') }}" class="inline-block px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-gray-100 transition">Kembali</a>
</p>
@endsection