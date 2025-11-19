@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold text-purple-200 mb-4">Daftar Warehouse</h2>
<form method="get" class="mb-4 flex items-center gap-2 w-full">
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
        <a href="{{ route('warehouses.index') }}"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-white">
            <i class="fa-solid fa-rotate-right"></i>
        </a>
    </div>
    <a href="{{ route('warehouses.create') }}" 
      class="flex-shrink-0 px-8 py-2 rounded-lg 
              bg-purple-500/70 hover:bg-purple-500/90 text-white transition">
        + Tambah
    </a>
</form>

<div class="overflow-hidden rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm">
  <table class="min-w-full text-sm text-gray-100">
    <thead class="bg-purple-500/20 text-purple-100">
      <tr>
        <th class="text-left px-4 py-3 w-16">No</th>
        <th class="text-left px-4 py-3 w-64">Nama</th>
        <th class="text-left px-4 py-3">Lokasi</th>
        <th class="text-left px-4 py-3 w-40">Aksi</th>
      </tr>
    </thead>

    <tbody class="divide-y divide-white/10">
      @forelse($warehouses as $i => $warehouse)
        <tr class="hover:bg-white/5 transition">
          <td class="px-4 py-3">{{ $warehouses->firstItem() + $i }}</td>
          <td class="px-4 py-3">{{ $warehouse->name }}</td>
          <td class="px-4 py-3">{{ $warehouse->location }}</td>
          <td class="px-4 py-3 flex items-center gap-2">
            <a href="{{ route('warehouses.show',$warehouse->id) }}" 
              class="text-yellow-500 hover:underline">Detail</a>
            <span class="text-gray-500">|</span>
            <a href="{{ route('warehouses.edit',$warehouse->id) }}" 
              class="text-purple-300 hover:underline">Edit</a>
            <span class="text-gray-500">|</span>
            <form action="{{ route('warehouses.destroy',$warehouse->id) }}" method="post" 
                  onsubmit="return confirm('hapus?')" class="inline">
              @csrf @method('DELETE')
              <button class="text-red-500 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-4 py-4 text-center text-gray-300">Belum ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $warehouses->links() }}
</div>
@endsection