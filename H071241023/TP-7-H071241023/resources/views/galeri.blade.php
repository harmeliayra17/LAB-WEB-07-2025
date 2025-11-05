@extends('layouts.master')

@section('content')

<section class="title text-center px-6 md:px-12 mt-8">
  <h2 class="text-3xl font-bold mb-2">Galeri Foto</h2>
  <p class="text-gray-600">Koleksi foto-foto kece pengunjung saat ekplor Kota Bandung</p>
</section>

<section class="max-w-7xl mx-auto px-6 md:px-12 py-8">
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach ($galeri as $item)
      @php
        $image   = $item['image'] ?? '';
        $title = $item['title'] ?? pathinfo($image, PATHINFO_FILENAME);
        $text  = $item['text']  ?? 'Lihat detail foto';
      @endphp

      <figure class="group relative border rounded-md overflow-hidden shadow-sm">
        {{-- gambar --}}
        <img src="{{ asset($image) }}"
            alt="{{ $title }}"
            loading="lazy" decoding="async"
            class="w-full h-[180px] object-cover transition-transform duration-300 group-hover:scale-105">

        {{-- overlay gelap saat hover --}}
        <div class="absolute inset-0 bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

        <figcaption class="absolute inset-x-0 bottom-0 p-3 text-white opacity-0 translate-y-3
            transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0">
          <h4 class="font-semibold text-sm line-clamp-1">{{ $title }}</h4>
          <p class="text-xs text-white/90 line-clamp-2">{{ $text }}</p>
        </figcaption>
      </figure>
    @endforeach
  </div>
</section>

@endsection