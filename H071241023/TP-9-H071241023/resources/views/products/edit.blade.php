@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold text-purple-200 mb-4">Edit Produk</h2>
<form method="post" action="{{ route('products.update',$product->id) }}" class="space-y-5">
  @csrf @method('PUT')
  <div>
    <label for="name" class="block text-sm text-purple-200 mb-1">Nama</label>
    <input id="name" name="name" value="{{ old('name',$product->name) }}" required
          class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400/60">
  </div>
  <div>
    <label for="category_id" class="block text-sm text-purple-200 mb-1">Kategori</label>
    <select id="category_id" name="category_id"
            class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                  focus:outline-none focus:ring-2 focus:ring-purple-400/60">
      <option value="">-- tanpa kategori —</option>
      @foreach($categories as $categori)
        <option value="{{ $categori->id }}" @selected(old('category_id',$product->category_id)==$categori->id)>{{ $categori->name }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label for="price" class="block text-sm text-purple-200 mb-1">Harga</label>
    <input id="price" type="number" name="price" value="{{ old('price',$product->price) }}" required
          class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                  focus:outline-none focus:ring-2 focus:ring-purple-400/60">
  </div>
  <hr class="border-white/10">
  <h4 class="text-lg font-semibold text-purple-200">Detail Produk</h4>
  <div>
    <label for="description" class="block text-sm text-purple-200 mb-1">Deskripsi</label>
    <textarea id="description" name="description" rows="4"
              class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                    placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400/60">{{ old('description',$product->detail->description ?? '') }}</textarea>
  </div>
  <div class="grid sm:grid-cols-2 gap-4">
    <div>
      <label for="weight" class="block text-sm text-purple-200 mb-1">Berat (kg)</label>
      <input id="weight" type="number" step="0.01" name="weight" 
            value="{{ old('weight',$product->detail->weight ?? '') }}" required
            class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                    focus:outline-none focus:ring-2 focus:ring-purple-400/60">
    </div>
    <div>
      <label for="size" class="block text-sm text-purple-200 mb-1">Ukuran</label>
      <input id="size" name="size" value="{{ old('size',$product->detail->size ?? '') }}"
            class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                    focus:outline-none focus:ring-2 focus:ring-purple-400/60">
    </div>
  </div>

  <div class="flex items-center gap-2">
    <button class="px-4 py-2 rounded-lg bg-purple-500/70 hover:bg-purple-500/90 text-white transition">Update</button>
    <a href="{{ route('products.index') }}" 
      class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-gray-100 transition">Kembali</a>
  </div>
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