@extends('layouts.master')

@section('title', 'Kuliner Khas - Eksplor Balikpapan')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">🍜 Kuliner Khas Balikpapan</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Nikmati cita rasa autentik Kota Minyak yang menggugah selera</p>
    </div>

    <!-- Kuliner Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Soto Banjar -->
        <x-card 
            title="🍲 Soto Banjar" 
            image="{{ asset('images/kuliner/soto-banjar.jpg') }}"
            description="Soto khas Kalimantan Selatan yang populer di Balikpapan dengan kuah bening gurih beraroma kayu manis dan kapulaga. Disajikan dengan ayam kampung empuk, perkedel, telur rebus, dan ketupat.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.6/5</span>
                <span class="text-green-500 text-sm">💰 Rp 15-25K</span>
            </div>
        </x-card>

        <!-- Kepiting Soka -->
        <x-card 
            title="🦀 Kepiting Soka" 
            image="{{ asset('images/kuliner/kepiting-soka.jpg') }}"
            description="Kepiting rajungan dengan kulit lunak yang bisa dimakan seluruhnya. Digoreng garing dengan bumbu tepung atau saus padang pedas gurih. Sensasi renyah di luar lembut di dalam.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.8/5</span>
                <span class="text-red-500 text-sm">💰 Rp 80-150K</span>
            </div>
        </x-card>

        <!-- Nasi Kuning Khas Balikpapan -->
        <x-card 
            title="🍚 Nasi Kuning Khas" 
            image="{{ asset('images/kuliner/nasi-kuning.jpg') }}"
            description="Nasi kuning dimasak dengan santan kental, kunyit, dan rempah pilihan. Dilengkapi ayam goreng kuning, telur balado, serundeng, perkedel, dan kerupuk dalam porsi besar.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.5/5</span>
                <span class="text-blue-500 text-sm">💰 Rp 20-35K</span>
            </div>
        </x-card>

        <!-- Amplang -->
        <x-card 
            title="🐟 Amplang" 
            image="{{ asset('images/kuliner/amplang.jpg') }}"
            description="Kerupuk khas dari ikan tenggiri dengan tekstur krispi dan rasa gurih. Oleh-oleh wajib Balikpapan yang tersedia dalam berbagai ukuran dan bentuk.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.7/5</span>
                <span class="text-purple-500 text-sm">💰 Rp 25-60K</span>
            </div>
        </x-card>

        <!-- Lawa Ayam -->
        <x-card 
            title="🍗 Lawa Ayam" 
            image="{{ asset('images/kuliner/lawa-ayam.jpg') }}"
            description="Gulai tradisional Dayak dengan darah ayam sebagai pengental kuah. Rasa gurih pedas khas dengan rempah lengkuas, serai, dan daun jeruk.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.4/5</span>
                <span class="text-orange-500 text-sm">💰 Rp 25-40K</span>
            </div>
        </x-card>

        <!-- Gangan Ikan Patin -->
        <x-card 
            title="🐠 Gangan Ikan Patin" 
            image="{{ asset('images/kuliner/gangan-patin.jpg') }}"
            description="Sup ikan patin dengan kuah kuning asam pedas menyegarkan. Dimasak dengan belimbing wuluh, kunyit, lengkuas, dan daun kemangi.">
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-yellow-500 text-sm">⭐ 4.6/5</span>
                <span class="text-green-500 text-sm">💰 Rp 35-60K</span>
            </div>
        </x-card>
    </div>

    <!-- Rekomendasi Tempat Makan -->
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-8 border border-amber-200">
        <h3 class="text-2xl font-bold text-amber-800 mb-6">🍽️ Rekomendasi Tempat Makan Terbaik</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-amber-100">
                <h4 class="font-bold text-gray-800 mb-3 text-lg">🏪 Pasar Inpres Kebun Sayur</h4>
                <p class="text-gray-600">Pusat kuliner tradisional dengan berbagai pilihan makanan khas Kalimantan</p>
                <div class="mt-3 flex items-center text-sm text-amber-600">
                    <span>⭐ 4.3</span>
                    <span class="mx-2">•</span>
                    <span>💰 Murah</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-amber-100">
                <h4 class="font-bold text-gray-800 mb-3 text-lg">🏬 Sepinggan Food Court</h4>
                <p class="text-gray-600">Food court modern dengan berbagai pilihan kuliner seafood segar</p>
                <div class="mt-3 flex items-center text-sm text-amber-600">
                    <span>⭐ 4.5</span>
                    <span class="mx-2">•</span>
                    <span>💰 Sedang</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-amber-100">
                <h4 class="font-bold text-gray-800 mb-3 text-lg">🍲 Warung Soto Banjar H. Amat</h4>
                <p class="text-gray-600">Legendaris! Soto Banjar paling enak sejak tahun 1980-an</p>
                <div class="mt-3 flex items-center text-sm text-amber-600">
                    <span>⭐ 4.8</span>
                    <span class="mx-2">•</span>
                    <span>💰 Murah</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-amber-100">
                <h4 class="font-bold text-gray-800 mb-3 text-lg">🌊 Pantai Melawai</h4>
                <p class="text-gray-600">Deretan restoran seafood dengan pemandangan laut yang indah</p>
                <div class="mt-3 flex items-center text-sm text-amber-600">
                    <span>⭐ 4.4</span>
                    <span class="mx-2">•</span>
                    <span>💰 Mahal</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Harga -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-8 border border-green-200">
        <div class="flex items-start gap-4">
            <div class="text-3xl">💰</div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-green-800 mb-6">Kisaran Harga Kuliner</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 text-green-900">
                    <div class="bg-white rounded-lg p-4 text-center border border-green-100">
                        <div class="font-bold text-green-600">Soto Banjar</div>
                        <div class="text-sm">Rp 15.000 - 25.000</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center border border-green-100">
                        <div class="font-bold text-green-600">Kepiting Soka</div>
                        <div class="text-sm">Rp 80.000 - 150.000</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center border border-green-100">
                        <div class="font-bold text-green-600">Nasi Kuning</div>
                        <div class="text-sm">Rp 20.000 - 35.000</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center border border-green-100">
                        <div class="font-bold text-green-600">Amplang</div>
                        <div class="text-sm">Rp 25.000 - 60.000</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center border border-green-100">
                        <div class="font-bold text-green-600">Lawa Ayam</div>
                        <div class="text-sm">Rp 25.000 - 40.000</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center border border-green-100">
                        <div class="font-bold text-green-600">Gangan Ikan Patin</div>
                        <div class="text-sm">Rp 35.000 - 60.000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-2xl p-8">
        <h3 class="text-2xl font-bold mb-4">Lapar Melihat Kuliner Balikpapan?</h3>
        <p class="text-amber-100 mb-6">Jelajahi lebih banyak keindahan kota ini</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('destinasi') }}" class="bg-white text-amber-600 px-6 py-3 rounded-lg font-semibold hover:bg-amber-50 transition duration-300">
                🗺️ Lihat Destinasi Wisata
            </a>
            <a href="{{ route('galeri') }}" class="bg-amber-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-amber-500 transition duration-300">
                📸 Jelajahi Galeri
            </a>
        </div>
    </div>
</div>
@endsection