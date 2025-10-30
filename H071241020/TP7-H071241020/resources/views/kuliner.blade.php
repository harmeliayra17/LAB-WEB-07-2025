@extends('layouts.master')
@section('title', 'Kuliner')

@section('content')
<h2 style="text-align:center; margin:2.5rem 0; color:#1e40af; font-size:2rem;">
    Kuliner Khas Polewali Mandar
</h2>
<div class="cards">
    <x-card
        title="Nasi Berenang"
        description="Kuliner legendaris Polman. Nasi putih disiram kuah kaldu ayam kental
        berwarna kuning keemasan, ditambah irisan telur rebus, daun bawang, dan sambal.
        Rasa gurih hangat, cocok dinikmati pagi hari di warung tradisional."
        image="{{ asset('images/k-nasber.png') }}"
    />
    <x-card
        title="Jepa"
        description="'Pizza Mandar' dari sagu tipis yang dipanggang di atas bara api.
        Topping: ikan suwir, kelapa parut, bawang goreng, dan bumbu rempah khas.
        Tekstur renyah di luar, lembut di dalam. Wajib coba saat festival kuliner!"
        image="{{ asset('images/k-jepa.png') }}"
    />
    <x-card
        title="Kopi Kurrak"
        description="Kopi Arabika premium dari pegunungan Polman (Kec. Tapango).
        Rasa fruity dengan aroma karamel, pernah diekspor ke Eropa.
        Disajikan tradisional dengan gula aren dan sedikit garam.
        Bisa dibeli sebagai oleh-oleh di Kampung Rumede."
        image="{{ asset('images/k-kopi_kurra.png') }}"
    />
</div>

<div style="height:100px;"></div>
@endsection
