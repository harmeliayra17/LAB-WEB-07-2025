@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold text-purple-200 mb-4">Stok Per Warehouse</h2>

<form method="get" class="space-y-3">
  <label class="text-purple-200">Pilih Warehouse:</label>
  <select name="warehouse_id" onchange="this.form.submit()"
          class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                focus:outline-none focus:ring-2 focus:ring-purple-400/60">
    <option value="">-- pilih --</option>
    @foreach($warehouses as $warehouse)
      <option value="{{ $warehouse->id }}" @selected($selectedWarehouseId==$warehouse->id)>{{ $warehouse->name }}</option>
    @endforeach
  </select>
</form>

@if($selectedWarehouseId)
  <div class="mt-5 overflow-hidden rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm">
    <table class="min-w-full text-sm text-gray-100 border border-white/20 border-collapse">
      <thead class="bg-purple-500/30 text-purple-100">
        <tr>
          <th class="border border-white/20 px-4 py-2 text-left">Produk</th>
          <th class="border border-white/20 px-4 py-2 text-left">Kategori</th>
          <th class="border border-white/20 px-4 py-2 text-right">Qty</th>
        </tr>
      </thead>
      <tbody>
        @forelse($productsInWarehouse as $productWarehouse)
          <tr class="hover:bg-white/5 transition">
            <td class="border border-white/10 px-4 py-2">{{ $productWarehouse->name }}</td>
            <td class="border border-white/10 px-4 py-2">{{ $productWarehouse->category->name ?? '-' }}</td>
            <td class="border border-white/10 px-4 py-2 text-right">{{ $productWarehouse->pivot->quantity }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="border border-white/10 px-4 py-3 text-center text-gray-300">
              Belum ada stok
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@else
  <p class="mt-3 text-gray-600">Pilih Warehouse untuk melihat stok.</p>
@endif
<style>
  select option {
    color: #353535;
  }
  select option:checked,
  select option:hover,
  select option:focus {
    background-color: #8b5cf6 !important; 
    color: #ffffff !important;
  }
</style>
@endsection