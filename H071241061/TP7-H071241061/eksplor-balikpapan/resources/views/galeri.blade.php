@extends('layouts.master')

@section('title', 'Galeri Foto - Eksplor Balikpapan')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">📸 Galeri Foto Balikpapan</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Keindahan Kota Minyak dalam Setiap Bingkai</p>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach([
            [
                'image' => 'balikpapan-skyline.jpg',
                'title' => 'Skyline Balikpapan',
                'desc' => 'Pemandangan kota modern dari ketinggian',
                'category' => '🏙️ Cityscape'
            ],
            [
                'image' => 'sunset-teluk.jpg', 
                'title' => 'Sunset Teluk Balikpapan',
                'desc' => 'Matahari terbenam yang memukau',
                'category' => '🌅 Alam'
            ],
            [
                'image' => 'jembatan-mangrove.jpg',
                'title' => 'Jembatan Kayu Mangrove',
                'desc' => 'Susur jalan di tengah hutan bakau',
                'category' => '🌿 Konservasi'
            ],
            [
                'image' => 'masjid-agung.jpg',
                'title' => 'Masjid Agung At-Taqwa', 
                'desc' => 'Landmark religi megah di pusat kota',
                'category' => '🕌 Landmark'
            ],
            [
                'image' => 'pantai-kemala-malam.jpg',
                'title' => 'Pantai Kemala di Malam Hari',
                'desc' => 'Gemerlap lampu kota dari tepi pantai',
                'category' => '🌃 Nightscape'
            ],
            [
                'image' => 'monumen-perjuangan.jpg',
                'title' => 'Monumen Perjuangan Rakyat',
                'desc' => 'Simbol sejarah perjuangan kota',
                'category' => '🏛️ Sejarah'
            ],
            [
                'image' => 'bekantan.jpg',
                'title' => 'Bekantan Khas Kalimantan',
                'desc' => 'Primata endemik di habitat aslinya', 
                'category' => '🐒 Satwa'
            ],
            [
                'image' => 'jembatan-mahakam.jpg',
                'title' => 'Jembatan Mahakam Ulu',
                'desc' => 'Infrastruktur modern penghubung kota',
                'category' => '🌉 Infrastruktur'
            ],
            [
                'image' => 'plaza-balikpapan.jpg',
                'title' => 'Plaza Balikpapan',
                'desc' => 'Pusat perbelanjaan dan hiburan',
                'category' => '🏬 Modern'
            ],
            [
                'image' => 'budaya-dayak.jpg',
                'title' => 'Tarian Budaya Dayak',
                'desc' => 'Kekayaan seni dan budaya lokal',
                'category' => '🎭 Budaya'
            ],
            [
                'image' => 'pelabuhan.jpg',
                'title' => 'Pelabuhan Semayang',
                'desc' => 'Gerbang maritim Kalimantan Timur',
                'category' => '⚓ Maritim'
            ],
            [
                'image' => 'hutan-lindung.jpg',
                'title' => 'Hutan Lindung Sungai Wain',
                'desc' => 'Paru-paru hijau kota Balikpapan',
                'category' => '🌳 Konservasi'
            ]
        ] as $photo)
        <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 bg-white border border-gray-100">
            <img 
                src="{{ asset('images/galeri/' . $photo['image']) }}" 
                alt="{{ $photo['title'] }}" 
                class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500"
                loading="lazy"
            >
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-white text-xs bg-blue-500 px-2 py-1 rounded-full">{{ $photo['category'] }}</span>
                </div>
                <h3 class="text-white font-bold text-lg mb-1">{{ $photo['title'] }}</h3>
                <p class="text-gray-300 text-sm">{{ $photo['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Category Filter Info -->
    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-8 border border-purple-200">
        <h3 class="text-2xl font-bold text-purple-800 mb-6">📷 Kategori Foto Balikpapan</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['icon' => '🏙️', 'name' => 'Cityscape', 'count' => '3 foto'],
                ['icon' => '🌅', 'name' => 'Alam', 'count' => '4 foto'], 
                ['icon' => '🏛️', 'name' => 'Landmark', 'count' => '2 foto'],
                ['icon' => '🎭', 'name' => 'Budaya', 'count' => '1 foto'],
                ['icon' => '🌿', 'name' => 'Konservasi', 'count' => '2 foto'],
                ['icon' => '🌉', 'name' => 'Infrastruktur', 'count' => '2 foto'],
                ['icon' => '🐒', 'name' => 'Satwa', 'count' => '1 foto'],
                ['icon' => '⚓', 'name' => 'Maritim', 'count' => '1 foto']
            ] as $category)
            <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-purple-100 hover:shadow-md transition duration-300">
                <div class="text-2xl mb-2">{{ $category['icon'] }}</div>
                <p class="font-semibold text-gray-800">{{ $category['name'] }}</p>
                <p class="text-purple-600 text-sm mt-1">{{ $category['count'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl p-8">
        <h3 class="text-2xl font-bold mb-4">Punya Foto Menarik dari Balikpapan?</h3>
        <p class="text-purple-100 mb-6">Bagikan momen indah Anda dan jadilah bagian dari komunitas pecinta Balikpapan</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <span class="bg-white text-purple-600 px-4 py-2 rounded-full font-semibold text-sm hover:bg-purple-50 transition duration-300">
                #EksplorBalikpapan
            </span>
            <span class="bg-white text-purple-600 px-4 py-2 rounded-full font-semibold text-sm hover:bg-purple-50 transition duration-300">
                #KotaMinyak
            </span>
            <span class="bg-white text-purple-600 px-4 py-2 rounded-full font-semibold text-sm hover:bg-purple-50 transition duration-300">
                #WisataKaltim
            </span>
            <span class="bg-white text-purple-600 px-4 py-2 rounded-full font-semibold text-sm hover:bg-purple-50 transition duration-300">
                #BalikpapanIndah
            </span>
        </div>
        <div class="mt-6 flex flex-wrap gap-4 justify-center">
            <a href="{{ route('destinasi') }}" class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-purple-50 transition duration-300">
                🗺️ Jelajahi Destinasi
            </a>
            <a href="{{ route('kuliner') }}" class="bg-purple-400 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-500 transition duration-300">
                🍜 Coba Kuliner
            </a>
        </div>
    </div>
</div>
@endsection