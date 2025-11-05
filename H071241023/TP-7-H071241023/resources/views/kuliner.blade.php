@extends('layouts.master')

@section('content')
<section class="px-6 md:px-12 mt-8 text-center">
  <h2 class="text-3xl font-bold">Kuliner Khas Bandung</h2>
  <p class="mt-2 text-slate-600">Jalan-jalan pasti kurang afdol kalau gak mam, seberat apapun hidupmu, tetap lah mam</p>
</section>

{{-- PREVIEW --}}
<section class="max-w-7xl mx-auto px-6 md:px-12 py-6">
  <div class="relative">
    <div id="kuliner-slider"
        class="flex gap-4 overflow-x-auto no-scrollbar snap-x snap-mandatory scroll-smooth pb-2">
      @foreach ($kuliner as $index => $item)
        <div class="min-w-[300px] bg-white border rounded-md shadow-xl">
          <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" class="w-full h-[195px] object-cover rounded-t-md">
          <div class="p-3 text-center">
            <p class="font-semibold text-orange-950 text-sm mb-2">{{ $item['title'] }}</p>
            <button type="button"
                    class="text-sm bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-700"
                    data-target="kuliner-{{ $index }}">
              Lihat
            </button>
          </div>
        </div>
      @endforeach
    </div>

    <button type="button"
      class="absolute left-0 top-1/2 -translate-y-1/2 bg-gray-800 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-70 hover:opacity-100"
      data-slider="#kuliner-slider" data-dir="-1">‹</button>
    <button type="button"
      class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-800 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-70 hover:opacity-100"
      data-slider="#kuliner-slider" data-dir="1">›</button>
  </div>
</section>

{{-- === DETAIL === --}}
@foreach ($kuliner as $index => $item)
  <section id="kuliner-{{ $index }}" class="max-w-7xl mx-auto px-6 md:px-12 py-12 border-b border-gray-200 scroll-mt-20">
    <div class="grid md:grid-cols-2 gap-8 items-center">
      @if ($loop->odd)
        <div>
          <h3 class="text-xl font-bold mb-2">{{ $item['title'] }}</h3>
          <p class="text-gray-600">{{ $item['text'] }}</p>
        </div>
        <div>
          <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" class="w-full h-[350px] object-cover rounded-md">
        </div>
      @else
        <div class="order-2 md:order-1">
          <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" class="w-full h-[350px] object-cover rounded-md">
        </div>
        <div class="order-1 md:order-2">
          <h3 class="text-xl font-bold mb-2">{{ $item['title'] }}</h3>
          <p class="text-gray-600">{{ $item['text'] }}</p>
        </div>
      @endif
    </div>
  </section>
@endforeach
@endsection