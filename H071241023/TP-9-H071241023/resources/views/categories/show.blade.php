@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold text-purple-200 mb-4">Detail Kategori</h2>
<div class="overflow-hidden rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm">
  <table class="min-w-full text-sm text-gray-100">
    <tbody class="[&>tr:nth-child(even)]:bg-white/5">
      <tr>
        <td class="px-4 py-3 text-gray-300 w-40">Nama</td>
        <td class="px-4 py-3">{{ $category->name }}</td>
      </tr>
      <tr>
        <td class="px-4 py-3 text-gray-300">Deskripsi</td>
        <td class="px-4 py-3">{{ $category->description ?? '-' }}</td>
      </tr>
    </tbody>
  </table>
</div>

<h3 class="text-lg font-semibold text-purple-200 mt-6 mb-3">Produk dalam Kategori Ini</h3>
<form method="get" class="mb-3 flex items-center gap-2">
  <input type="text" name="search" value="{{ $searchKeyword }}" placeholder="Cari produk…"
        class="flex-1 rounded-lg bg-white/10 border border-white/10 text-gray-100 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400/60">
  <button class="px-10 py-2 rounded-lg bg-purple-500/70 hover:bg-purple-500/90 text-white transition">Cari</button>
</form>
<div class="overflow-hidden rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm">
  <table class="min-w-full text-sm">
    <thead class="bg-purple-500/20 text-purple-100">
      <tr>
        <th class="text-left px-4 py-3">No</th>
        <th class="text-left px-4 py-3">Nama Produk</th>
        <th class="text-left px-4 py-3">Kategori</th>
        <th class="text-left px-4 py-3">Harga</th>
        <th class="text-left px-4 py-3">Berat</th>
        <th class="text-left px-4 py-3">Ukuran</th>
        <th class="text-left px-4 py-3">Deskripsi</th>
        <th class="text-left px-4 py-3">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-white/10">
      @forelse($products as $index => $product)
        <tr class="hover:bg-white/5">
          <td class="px-4 py-3">{{ $products->firstItem() + $index }}</td>
          <td class="px-4 py-3">{{ $product->name }}</td>
          <td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
          <td class="px-4 py-3">{{ number_format($product->price,0,',','.') }}</td>
          <td class="px-4 py-3">{{ $product->detail->weight ?? '-' }}</td>
          <td class="px-4 py-3">{{ $product->detail->size ?? '-' }}</td>
          <td class="px-4 py-3">{{ $product->detail->description ?? '-' }}</td>
          <td class="px-4 py-3">
            <a href="{{ route('products.show', $product->id) }}" class="text-yellow-500 hover:underline">Detail</a>
            <span class="text-gray-500">|</span>
            <a href="{{ route('products.edit', $product->id) }}" class="text-purple-300 hover:underline">Edit</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" class="px-4 py-4 text-center text-gray-300">No data available</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4">
  {{ $products->links() }}
</div>
<p class="mt-4">
  <a href="{{ route('categories.index') }}" class="inline-block px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-gray-100 transition">Kembali</a>
</p>
@endsection