@extends('layouts.master')
@section('title', 'Destinasi')

@section('content')
<h2 style="text-align:center; margin:2.5rem 0; color:#1e40af; font-size:2rem;">
    Destinasi Wisata Unggulan Polewali Mandar
</h2>
<div class="cards">
    <x-card
        title="Pantai Mampie"
        description="Pantai terpanjang di Polman (3 km) dengan deretan pohon kelapa menjulang.
        Aktivitas favorit: snorkeling, banana boat, memancing, dan menikmati ikan bakar segar
        di warung pinggir pantai. Fasilitas: gazebo, toilet umum, parkir luas. Akses: 15 menit dari kota."
        image="{{ asset('images/d-mampie.png') }}"
    />
    <x-card
        title="Pantai Palippis"
        description="Keindahan pasir putih lembut berpadu perbukitan hijau.
        Spot terbaik untuk foto sunset dan piknik keluarga. Air jernih, ombak tenang,
        cocok untuk berenang anak-anak. Tersedia penyewaan tikar dan payung pantai."
        image="{{ asset('images/d-palippis.png') }}"
    />
    <x-card
        title="Wisata Alam Patipo (Desa Kunyi)"
        description="Surga tersembunyi di Kecamatan Anreapi. Sungai jernih mengalir di antara bebatuan,
        dikelilingi hutan alami. Cocok untuk camping, trekking ringan, dan terapi alam.
        Tiket masuk: Rp5.000/orang. Tersedia homestay warga."
        image="{{ asset('images/d-desa_kunyi.png') }}"
    />
</div>

<!-- TAMBAHAN: SPACER AGAR LEBIH PANJANG -->
<div style="height:100px;"></div>
@endsection
