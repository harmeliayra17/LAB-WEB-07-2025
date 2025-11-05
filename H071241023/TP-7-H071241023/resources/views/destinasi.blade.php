@extends('layouts.master')

@section('content')

<section class="title text-center px-6 md:px-12 mt-8">
    <h2 class="text-3xl md:text-4xl font-bold">Destinasi Unggulan di Bandung</h2>
    <p class="mt-2 text-slate-600">Bandung seindah ini, yakali gak dieksplor.</p>
</section>

@foreach ($destinasi as $d)
    @php
        $sideImages = array_slice($d['images'] ?? [], 1);
    @endphp

    <section class="spotlight max-w-7xl mx-auto px-4 sm:px-6 md:px-12 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- FOTO KIRI --}}
            <div class="relative h-[250px] sm:h-[320px] md:h-[380px] rounded-2xl overflow-hidden md:col-span-2">
                <img src="{{ asset($d['images'][0]) }}" 
                    alt="{{ $d['title'] }} hero"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40"></div>

                <div class="absolute inset-0 p-5 sm:p-8 flex flex-col justify-end text-white">
                    <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold">{{ $d['title'] }}</h3>
                    <p class="mt-2 text-sm sm:text-base max-w-2xl text-white/90 leading-relaxed">{{ $d['text'] }}</p>
                </div>
            </div>

            {{-- FOTO KANAN --}}
            <div class="relative h-[240px] sm:h-[300px] md:h-[380px] flex items-center md:items-stretch md:col-span-1">
                <div id="slider-{{ $loop->index }}"
                    class="flex gap-4 sm:gap-6 overflow-x-auto no-scrollbar snap-x snap-mandatory scroll-smooth w-full">
                @foreach ($sideImages as $img)
                    <div class="relative min-w-[180px] sm:min-w-[220px] md:min-w-[260px] h-[220px] sm:h-[280px] md:h-[350px] rounded-2xl overflow-hidden snap-start">
                        <img src="{{ asset($img) }}" alt="{{ $d['title'] }}"
                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60"></div>
                        <h4 class="absolute bottom-3 left-4 right-4 text-white font-semibold text-sm sm:text-base drop-shadow">
                            {{ $d['title'] }}
                        </h4>
                    </div>
                @endforeach
                </div>
                <button type="button"
                class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center z-20"
                data-slider="#slider-{{ $loop->index }}" data-dir="-1" aria-label="Prev">‹</button>
                
                <button type="button"
                class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center z-20"
                data-slider="#slider-{{ $loop->index }}" data-dir="1" aria-label="Next">›</button>
            </div>
        </div>
    </section>
@endforeach
@endsection