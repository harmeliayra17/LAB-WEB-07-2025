@extends('layouts.master')

@section('title', 'Galeri Foto Tashkent')

@section('content')

<style>
    .gallery-grid {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
        gap: 10px; 
        justify-items: center; 
        align-items: stretch; 
    }

    .gallery-grid img {
        width: 100%; 
        height: 200px; 
        object-fit: cover; 
        border: 1px solid #ddd; 
        border-radius: 4px; 
    }
</style>


    <h2>Galeri Foto</h2>
    <p>Menikmati perpaduan modern dan historis Tashkent dalam bingkai foto.</p>

    <div class="gallery-grid"> 
        <img src="{{ asset('images/t1.jpg') }}" alt="Foto Galeri Tashkent 1">
        <img src="{{ asset('images/t2.jpg') }}" alt="Foto Galeri Tashkent 2">
        <img src="{{ asset('images/t3.jpg') }}" alt="Foto Galeri Tashkent 3">
        <img src="{{ asset('images/t4.jpg') }}" alt="Foto Galeri Tashkent 4">
        <img src="{{ asset('images/t5.jpg') }}" alt="Foto Galeri Tashkent 5">
        <img src="{{ asset('images/t6.jpg') }}" alt="Foto Galeri Tashkent 6">
    </div>

@endsection