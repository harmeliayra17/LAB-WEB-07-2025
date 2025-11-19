@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h2 class="text-xl font-semibold text-purple-200">Daftar Produk</h2>
</div>

<form method="get" class="mb-3 flex items-center gap-2 w-full">
    <div class="relative flex-1 min-w-0">
        <input type="text" 
            name="search"
            value="{{ $searchKeyword }}"
            placeholder="Cari nama…"
            class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100
                  pl-10 pr-20 py-2 placeholder-gray-400
                  focus:outline-none focus:ring-2 focus:ring-purple-400/60">
        <button type="submit"
            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-white">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>

        <a href="{{ route('products.index') }}"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-white">
            <i class="fa-solid fa-rotate-right"></i>
        </a>
    </div>
    <a href="{{ route('products.create') }}"
        class="flex-shrink-0 px-8 py-2 rounded-lg 
              bg-purple-500/70 hover:bg-purple-500/90 text-white transition">
        + Tambah
    </a>
</form>

<div class="overflow-hidden rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm">
  <table class="min-w-full text-sm">
    <thead class="bg-purple-500/20 text-purple-100">
      <tr>
        <th class="text-left px-4 py-3">No</th>
        <th class="text-left px-4 py-3">Nama</th>
        <th class="text-left px-4 py-3">Kategori</th>
        <th class="text-left px-4 py-3">Harga</th>
        <th class="text-left px-4 py-3">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-white/10">
      @forelse($products as $i => $product)
        <tr class="hover:bg-white/5">
          <td class="px-4 py-3">{{ $products->firstItem() + $i }}</td>
          <td class="px-4 py-3">{{ $product->name }}</td>
          <td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
          <td class="px-4 py-3">{{ number_format($product->price,0,',','.') }}</td>
          <td class="px-4 py-3">
            <a href="{{ route('products.show',$product->id) }}" class="text-yellow-500 hover:underline">Detail</a>
            <span class="text-gray-500">|</span>
            <a href="{{ route('products.edit',$product->id) }}" class="text-purple-300 hover:underline">Edit</a>
            <span class="text-gray-500">|</span>
            <form action="{{ route('products.destroy',$product->id) }}" method="post" class="inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('hapus?')" class="text-red-500 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-4 py-4 text-center text-gray-300">Belum ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $products->links() }}
</div>
@endsection