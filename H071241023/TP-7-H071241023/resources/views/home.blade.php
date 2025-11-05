@extends('layouts.master')

@section('content')
<div id="hero"
    class="relative min-h-screen bg-cover bg-center flex flex-col justify-center items-center text-white"
    style="background-image: url('{{ asset('images/bg1.jpg') }}');">

    <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center mt-20"> 
            <h1 class="text-5xl font-bold mb-4 drop-shadow-lg">Selamat Datang di Bandung</h1>
            <p class="text-lg drop-shadow-md">Kota dengan 1001 Cerita & Keindahan Alam</p>
        </div>
    </div>
@endsection
