@extends('layouts.master')

@section('content')
    <h2 class="text-3xl font-bold mb-6 text-center">Galeri Jogja</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <img src="{{ asset('images/keraton.jpg') }}" alt="Keraton Yogyakarta" class="w-full h-auto object-contain rounded-lg">
        <img src="{{ asset('images/tamansari.jpg') }}" alt="Taman Sari" class="w-full h-auto object-contain rounded-lg">
        <img src="{{ asset('images/rumahgua.jpg') }}" alt="Rumah Fadel" class="w-full h-auto object-contain rounded-lg">
        <img src="{{ asset('images/malioboro-night.jpg') }}" alt="Malioboro Malam" class="w-full h-auto object-contain rounded-lg">
        <img src="{{ asset('images/wayang.jpg') }}" alt="Wayang Kulit" class="w-full h-auto object-contain rounded-lg">
        <img src="{{ asset('images/batik.jpg') }}" alt="Batik Jogja" class="w-full h-auto object-contain rounded-lg">
    </div>
@endsection