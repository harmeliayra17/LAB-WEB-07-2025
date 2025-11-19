@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold text-purple-200 mb-4">Edit Warehouse</h2>

<form method="post" action="{{ route('warehouses.update',$warehouse->id) }}" class="space-y-5">
  @csrf @method('PUT')
  <div>
    <label for="name" class="block text-sm text-purple-200 mb-1">Nama Warehouse</label>
    <input id="name" name="name" value="{{ old('name',$warehouse->name) }}" required
        class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
          placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400/60">
  </div>

  <div>
    <label for="location" class="block text-sm text-purple-200 mb-1">Lokasi</label>
    <textarea id="location" name="location" rows="4"
              class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100 px-3 py-2 
                placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400/60">{{ old('location',$warehouse->location) }}</textarea>
  </div>

  <div class="flex items-center gap-2">
    <button class="px-4 py-2 rounded-lg bg-purple-500/70 hover:bg-purple-500/90 text-white transition">
      Update
    </button>

    <a href="{{ route('warehouses.index') }}" 
      class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-gray-100 transition">
      Kembali
    </a>
  </div>
</form>
@endsection