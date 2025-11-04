@extends('layouts.master')

@section('title', 'Destinasi Wisata Tashkent')

@section('content')
    <h2>Destinasi Wisata Unggulan</h2>
    <p>Berikut adalah beberapa tempat wisata yang wajib Anda kunjungi di Tashkent.</p>
    
    <div class="card-container">
        <x-card 
            image="metro.jpg" 
            title="Tashkent Metro" 
            description="Bukan sekadar transportasi, stasiun-stasiun Metro Tashkent adalah galeri seni bawah tanah yang didekorasi dengan mewah." 
        />
        
        <x-card 
            image="chorsu.jpg" 
            title="Chorsu Bazaar" 
            description="Pasar tradisional di bawah kubah biru raksasa, tempat Anda bisa menemukan segala hal mulai dari rempah-rempah hingga kerajinan tangan." 
        />

        <x-card 
            image="amir-timur.jpg" 
            title="Amir Timur Square" 
            description="Alun-alun pusat kota yang didedikasikan untuk pahlawan nasional Amir Timur, dikelilingi oleh bangunan-bangunan penting." 
        />
    </div>
@endsection