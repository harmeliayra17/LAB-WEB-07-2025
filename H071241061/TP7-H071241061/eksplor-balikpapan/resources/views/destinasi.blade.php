@extends('layouts.master')

@section('title', 'Destinasi Wisata - Eksplor Balikpapan')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">🗺️ Destinasi Wisata Balikpapan</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Jelajahi tempat-tempat menakjubkan di Kota Minyak dengan pesona alam yang memukau</p>
    </div>

    <!-- Destinasi Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Penangkaran Buaya Teritip -->
        <x-card 
            title="🐊 Penangkaran Buaya Teritip" 
            image="{{ asset('images/destinasi/penangkaran-buaya.jpg') }}"
            description="Satu-satunya penangkaran buaya resmi di Balikpapan yang menjadi rumah bagi puluhan buaya muara (Crocodylus porosus). Pengunjung dapat melihat dari dekat berbagai ukuran buaya mulai dari anakan hingga buaya raksasa berusia puluhan tahun.">
    
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.3/5</span>
                <span class="text-green-500 text-sm">📍 Teritip</span>
            </div>
        </x-card>

        <!-- Hutan Mangrove Margomulyo -->
        <x-card 
            title="🌿 Hutan Mangrove Margomulyo" 
            image="{{ asset('images/destinasi/mangrove.jpg') }}"
            description="Kawasan konservasi mangrove seluas 24 hektar dengan jembatan kayu sepanjang 1,2 km. Spot edukasi flora fauna dan pelestarian lingkungan.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.7/5</span>
                <span class="text-green-500 text-sm">📍 Margomulyo</span>
            </div>
        </x-card>

        <!-- Bukit Bangkirai -->
        <x-card 
            title="🌳 Bukit Bangkirai" 
            image="{{ asset('images/destinasi/bangkirai.jpg') }}"
            description="Taman wisata alam dengan canopy bridge setinggi 30 meter di antara pohon Bangkirai berusia ratusan tahun. Panorama hutan hujan tropis Kalimantan.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.8/5</span>
                <span class="text-purple-500 text-sm">📍 Samboja</span>
            </div>
        </x-card>

        <!-- Pantai Melawai -->
        <x-card 
            title="🌊 Pantai Melawai" 
            image="{{ asset('images/destinasi/pantai-melawai.jpg') }}"
            description="Pantai dengan pasir putih bersih dan ombak tenang, cocok untuk berenang keluarga. Deretan kafe seafood dan spot jogging dengan pemandangan laut.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.3/5</span>
                <span class="text-blue-500 text-sm">📍 Melawai</span>
            </div>
        </x-card>

        <!-- Ibu Kota Nusantara (IKN) -->
        <x-card 
            title="🏛️ Ibu Kota Nusantara (IKN)" 
            image="{{ asset('images/destinasi/ikn.jpg') }}"
            description="Proyek strategis nasional Ibu Kota Negara baru Indonesia yang terletak di Penajam Paser Utara, berdekatan dengan Balikpapan. Meskipun masih dalam tahap pembangunan, area ini sudah menjadi daya tarik wisata dengan view perkembangan konstruksi yang impressive. Pengunjung dapat melihat dari berbagai spot viewing area perkembangan pembangunan ibu kota baru yang futuristik. Menjadi destinasi menarik untuk menyaksikan sejarah bangsa Indonesia yang sedang ditulis.">
    
            <div class="mt-4 flex items-center justify-between">
            <span class="text-yellow-500 text-sm">⭐ 4.7/5</span>
            <span class="text-blue-500 text-sm">📍 Penajam Paser Utara</span>
            </div>
        </x-card>

        <!-- Kebun Raya Balikpapan -->
        <x-card 
            title="🌺 Kebun Raya Balikpapan" 
            image="{{ asset('images/destinasi/kebun-raya.jpg') }}"
            description="Kebun raya pertama di Kalimantan dengan koleksi ribuan spesies tumbuhan khas. Pusat penelitian, konservasi, dan edukasi flora tropika.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.4/5</span>
                <span class="text-green-500 text-sm">📍 Karang Joang</span>
            </div>
        </x-card>
    </div>

    <!-- Tips Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-200">
        <div class="flex items-start gap-4">
            <div class="text-3xl">💡</div>
            <div>
                <h3 class="text-2xl font-bold text-blue-800 mb-4">Tips Berkunjung ke Destinasi Wisata</h3>
                <div class="grid md:grid-cols-2 gap-4 text-blue-900">
                    <div class="flex items-center gap-3">
                        <span class="bg-blue-100 p-2 rounded-lg">⏰</span>
                        <span>Waktu terbaik: Pagi hari atau sore menjelang sunset</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="bg-blue-100 p-2 rounded-lg">☀️</span>
                        <span>Siapkan sunscreen dan topi untuk cuaca tropis</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="bg-blue-100 p-2 rounded-lg">📸</span>
                        <span>Bawa kamera untuk mengabadikan momen indah</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="bg-blue-100 p-2 rounded-lg">🌱</span>
                        <span>Jaga kebersihan dan kelestarian alam sekitar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl p-8">
        <h3 class="text-2xl font-bold mb-4">Siap Menjelajahi Balikpapan?</h3>
        <p class="text-blue-100 mb-6">Temukan lebih banyak pengalaman seru di kota ini</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('kuliner') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-300">
                🍜 Lihat Kuliner Khas
            </a>
            <a href="{{ route('galeri') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-400 transition duration-300">
                📸 Jelajahi Galeri
            </a>
        </div>
    </div>
</div>
@endsection