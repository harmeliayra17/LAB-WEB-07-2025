@extends('layouts.master')

@section('title', 'Home - Eksplor Balikpapan')

@section('content')
<div class="space-y-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl shadow-2xl p-8 md:p-12 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang di Balikpapan! 🌿</h2>
        <p class="text-xl text-blue-100 mb-6">Kota Minyak yang Penuh Pesona Alam</p>
        <p class="text-lg leading-relaxed max-w-3xl mx-auto">
            Balikpapan adalah kota terbesar di Kalimantan Timur yang dikenal sebagai "Kota Minyak" dan "Kota Beriman". 
            Terletak di pesisir timur Pulau Kalimantan, Balikpapan menawarkan perpaduan unik antara kehidupan urban modern 
            dan keindahan alam tropis yang memukau.
        </p>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card 
            title="🏖️ Destinasi Wisata" 
            description="Jelajahi pantai-pantai indah, hutan mangrove, dan spot sunset terbaik di Balikpapan.">
            <div class="mt-4">
                <a href="{{ route('destinasi') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300">
                    Lihat Destinasi →
                </a>
            </div>
        </x-card>

        <x-card 
            title="🍜 Kuliner Khas" 
            description="Nikmati kelezatan makanan khas Balikpapan yang menggugah selera dan kaya rempah.">
            <div class="mt-4">
                <a href="{{ route('kuliner') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-300">
                    Cicipi Kuliner →
                </a>
            </div>
        </x-card>

        <x-card 
            title="📸 Galeri Foto" 
            description="Lihat koleksi foto-foto menakjubkan dari berbagai sudut kota Balikpapan.">
            <div class="mt-4">
                <a href="{{ route('galeri') }}" class="inline-block bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition duration-300">
                    Buka Galeri →
                </a>
            </div>
        </x-card>
    </div>

    <!-- About Section -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <h3 class="text-3xl font-bold text-gray-800 mb-6 text-center">🌴 Mengenal Balikpapan</h3>
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div class="space-y-4 text-gray-700 leading-relaxed">
                <p>
                    Balikpapan memiliki sejarah panjang sebagai pusat perdagangan dan industri. 
                    Nama "Balikpapan" berasal dari legenda lokal tentang 10 papan yang kembali ke pantai 
                    setelah terpisah dari kapal.
                </p>
                <p>
                    Saat ini, Balikpapan telah berkembang menjadi kota modern dengan infrastruktur yang 
                    baik dan berbagai fasilitas wisata menarik. Kota ini juga menjadi gerbang menuju 
                    Ibu Kota Negara (IKN) Nusantara yang baru.
                </p>
                <p>
                    Dengan julukan "Kota Beriman", Balikpapan menawarkan keramahan masyarakatnya 
                    serta pesona alam yang masih alami.
                </p>
            </div>
            <div class="bg-gradient-to-br from-blue-100 to-green-100 rounded-xl p-6 text-center">
                <div class="text-4xl mb-4">🏙️</div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Fakta Cepat</h4>
                <p class="text-gray-600">Kota metropolitan dengan hati hijau</p>
            </div>
        </div>
    </div>

    <!-- Quick Facts -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 text-center shadow-lg">
            <div class="text-2xl font-bold mb-2">688.3 km²</div>
            <div class="text-blue-100 text-sm">Luas Wilayah</div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-6 text-center shadow-lg">
            <div class="text-2xl font-bold mb-2">700K+</div>
            <div class="text-green-100 text-sm">Penduduk</div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-xl p-6 text-center shadow-lg">
            <div class="text-2xl font-bold mb-2">6</div>
            <div class="text-amber-100 text-sm">Kecamatan</div>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl p-6 text-center shadow-lg">
            <div class="text-2xl font-bold mb-2">27°C</div>
            <div class="text-red-100 text-sm">Suhu Rata-rata</div>
        </div>
    </div>
</div>
@endsection