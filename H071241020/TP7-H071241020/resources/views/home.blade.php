@extends('layouts.master')
@section('title', 'Home')

@section('content')
<div class="hero">
    <img src="{{ asset('images/b-1.jpg') }}" alt="Pantai Sunset">
    <h2 style="margin:1.5rem 0; color:#1e40af;">Selamat Datang di Polewali Mandar</h2>
    <p style="max-width:800px; margin:0 auto; line-height:1.8;">
        Polewali Mandar (Polman) adalah kabupaten di Sulawesi Barat yang terkenal dengan pantai eksotis, budaya maritim Mandar, dan kuliner khas seperti <strong>Nasi Berenang</strong> dan <strong>Jepa</strong>. Nikmati keindahan Selat Makassar, perahu Sandeq, dan kopi Kurrak premium.
    </p>
</div>

<div style="display:flex; flex-wrap:wrap; gap:2rem; justify-content:center; margin:3rem 0;">
    <div style="flex:1; min-width:280px; text-align:center;">
        <img src="{{ asset('images/b-2.jpg') }}" style="width:100%; max-width:400px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.1);">
        <p style="margin-top:1rem; font-style:italic;">Perahu Sandeq – Ikon Budaya Mandar</p>
    </div>
    <div style="flex:1; min-width:280px; text-align:center;">
        <img src="{{ asset('images/b-3.jpg') }}" style="width:100%; max-width:400px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.1);">
        <p style="margin-top:1rem; font-style:italic;">Hutan Mangrove</p>
    </div>
</div>
@endsection
