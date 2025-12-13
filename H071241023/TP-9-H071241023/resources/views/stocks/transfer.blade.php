@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold text-purple-200 mb-4">Transfer Stok</h2>

<form method="post" action="{{ route('stocks.transfer.store') }}" class="space-y-4">
  @csrf
  <div>
    <label class="block text-sm text-purple-200 mb-1">Warehouse</label>
    <select name="warehouse_id" required
            class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                  focus:outline-none focus:ring-2 focus:ring-purple-400/60">
      <option value="">— pilih warehouse —</option>
      @foreach($warehouses as $warehouse)
        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label class="block text-sm text-purple-200 mb-1">Produk</label>
    <select name="product_id" required
            class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                  focus:outline-none focus:ring-2 focus:ring-purple-400/60">
      <option value="">— pilih produk—</option>
      @foreach($products as $product)
        <option value="{{ $product->id }}">{{ $product->name }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label class="block text-sm text-purple-200 mb-1">Perubahan Stok</label>
    <input type="number" name="stock_change" placeholder="+10 atau -5" required
          class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                  focus:outline-none focus:ring-2 focus:ring-purple-400/60">
  </div>
  <button class="px-4 py-2 rounded-lg bg-purple-500/70 hover:bg-purple-500/90 text-white transition">
    Simpan
  </button>
</form>

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