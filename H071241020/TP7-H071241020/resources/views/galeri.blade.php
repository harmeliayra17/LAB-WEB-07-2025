@extends('layouts.master')
@section('title', 'Galeri')

@section('content')
<h2 style="text-align:center; margin:2.5rem 0; color:#1e40af; font-size:2rem;">
    Galeri Foto Polewali Mandar
</h2>
<div class="gallery" class="grid grid-cols-4" >
    <img src="{{ asset('images/g-1.png') }}" alt="Perahu Sandeq di Laut">
    <img src="{{ asset('images/g-2.png') }}" alt="Pantai Sunset">
    <img src="{{ asset('images/g-3.png') }}" alt="Kampung Adat">
    <img src="{{ asset('images/g-4.png') }}" alt="Festival Budaya">
    <img src="{{ asset('images/g-5.png') }}" alt="Kopi Panen">
</div>

<!-- TAMBAHAN: SPACER -->
<div style="height:120px;"></div>
@endsection
