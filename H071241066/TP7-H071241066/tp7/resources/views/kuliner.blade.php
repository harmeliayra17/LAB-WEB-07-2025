@extends('layouts.master')

@section('title', 'Kuliner Khas Bali - Eksplor Bali')

@section('content')
<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInOut {
        0%, 100% {
            opacity: 0;
        }
        20%, 80% {
            opacity: 1;
        }
    }

    .hero-text-clipped {
        font-size: 8rem;
        font-weight: 900;
        text-align: center;
        line-height: 1.1;
        background: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=1920&q=80') center/cover;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-transform: uppercase;
        letter-spacing: -0.05em;
        animation: fadeInOut 5s ease-in-out infinite;
    }

    .hero-subtitle-clipped {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1920&q=80') center/cover;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: fadeInOut 5s ease-in-out infinite;
        animation-delay: 0.5s;
    }

    .hero-backdrop {
        background: linear-gradient(135deg, rgba(38, 77, 82, 0.85), rgba(112, 128, 144, 0.75));
        backdrop-filter: blur(10px);
    }

    .food-float {
        animation: float 3s ease-in-out infinite;
    }

    .food-card {
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        transform-style: preserve-3d;
    }

    .food-card:hover {
        transform: rotateY(10deg) translateZ(20px);
        box-shadow: -20px 20px 60px rgba(0,0,0,0.3);
    }

    .food-card:hover .food-image {
        transform: scale(1.1) rotate(5deg);
    }

    .food-image {
        transition: transform 0.5s ease;
    }

    .badge {
        animation: rotate 10s linear infinite;
    }

    .recipe-step {
        animation: slideUp 0.6s ease-out backwards;
    }

    .recipe-step:nth-child(1) { animation-delay: 0.1s; }
    .recipe-step:nth-child(2) { animation-delay: 0.2s; }
    .recipe-step:nth-child(3) { animation-delay: 0.3s; }
    .recipe-step:nth-child(4) { animation-delay: 0.4s; }

    .diagonal-section {
        position: relative;
        padding: 100px 0;
    }

    .diagonal-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #7D8C9A 0%, #496549 100%);
        transform: skewY(-3deg);
        z-index: -1;
    }

    /* Responsive Text */
    @media (max-width: 768px) {
        .hero-text-clipped {
            font-size: 4rem;
        }
        .hero-subtitle-clipped {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .hero-text-clipped {
            font-size: 2.5rem;
        }
        .hero-subtitle-clipped {
            font-size: 1.2rem;
        }
    }
</style>

<section class="relative h-screen overflow-hidden" style="background-color: #264D52;">
    <div class="absolute inset-0 flex items-center justify-center hero-backdrop">
        <div class="text-center z-10 px-6">
            <h1 class="hero-text-clipped mb-6">
                Kuliner Khas Bali
            </h1>
            <p class="hero-subtitle-clipped">
                Cita Rasa Tradisional yang Menggoda
            </p>
            <div class="mt-8 flex justify-center gap-4">
                <span class="bg-white bg-opacity-20 backdrop-blur-lg px-6 py-3 rounded-full font-semibold text-lg border-2 border-opacity-30" style="color: #D8C0AA; border-color: #D8C0AA;">
                    50+ Menu Tradisional
                </span>
                <span class="bg-white bg-opacity-20 backdrop-blur-lg px-6 py-3 rounded-full font-semibold text-lg border-2 border-opacity-30" style="color: #D8C0AA; border-color: #D8C0AA;">
                     Rempah Autentik
                </span>
            </div>
        </div>
    </div>
    
</section>

<section class="container mx-auto px-6 py-32">
    <div class="relative">
        <div class="absolute -top-20 -left-20 w-40 h-40 rounded-full opacity-20 badge" style="background-color: #C59F82;"></div>
        <div class="grid md:grid-cols-5 gap-8 items-center">
            <div class="md:col-span-3">
                <div class="relative food-card rounded-3xl overflow-hidden shadow-2xl transform -rotate-3">
                    <img src="images/babi-guling.jpg" alt="Babi Guling" class="food-image w-full h-96 object-cover">
                    <div class="absolute top-6 right-6 px-6 py-3 rounded-full font-bold text-lg" style="background-color: #264D52; color: #D8C0AA;">
                        ⭐ Must Try!
                    </div>
                </div>
            </div>
            <div class="md:col-span-2">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4" style="background-color: #C59F82; color: #264D52;">
                    Signature Dish
                </span>
                <h2 class="text-5xl font-bold mb-6" style="color: #264D52;">Babi Guling</h2>
                <p class="text-lg leading-relaxed mb-6" style="color: #496549;">
                    Babi Guling adalah hidangan ikonik Bali yang terbuat dari babi utuh 
                    yang dibumbui dengan campuran rempah-rempah tradisional seperti kunyit, 
                    lengkuas, jahe, dan bawang putih. Babi kemudian dipanggang hingga 
                    kulitnya renyah dan dagingnya empuk juicy. Disajikan dengan nasi, 
                    lawar, dan sambal matah yang pedas.
                </p>
                <div class="space-y-3">
                    </div>
                    <div class="flex items-center gap-3" style="color: #264D52;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
</svg>
                        <span>Harga: Rp 40.000 - Rp 80.000</span>
                    </div>
                    <div class="flex items-center gap-3" style="color: #264D52;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                        <span>Rekomendasi: Ibu Oka, Ubud</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="diagonal-section">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="order-2 md:order-1">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4" style="background-color: #D8C0AA; color: #264D52;">
                    Street Food Favorite
                </span>
                <h2 class="text-5xl font-bold text-white mb-6">Sate Lilit</h2>
                <p class="text-white text-lg leading-relaxed mb-8">
                    Berbeda dengan sate pada umumnya, Sate Lilit menggunakan daging ikan 
                    giling (biasanya ikan tengiri atau tuna) yang dicampur dengan kelapa 
                    parut, santan, dan rempah-rempah khas Bali. Adonan ini dililitkan pada 
                    batang serai atau bambu, lalu dipanggang hingga harum dan berwarna 
                    kecokelatan. Aromanya yang khas dari serai membuat sate ini sangat 
                    menggugah selera.
                </p>
                <div class="bg-white bg-opacity-20 backdrop-blur rounded-2xl p-6">
                    <h3 class="text-white font-bold text-xl mb-4">Bahan Utama:</h3>
                    <div class="grid grid-cols-2 gap-3 text-white">
                        <div>✓ Ikan Tengiri</div>
                        <div>✓ Kelapa Parut</div>
                        <div>✓ Serai</div>
                        <div>✓ Rempah Bali</div>
                    </div>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <div class="relative food-card rounded-3xl overflow-hidden shadow-2xl transform rotate-3">
                    <img src="images/sate-lilit.jpg" alt="Sate Lilit" class="food-image w-full h-96 object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mx-auto px-6 py-32">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4" style="background-color: #264D52; color: #D8C0AA;">
                Traditional Recipe
            </span>
            <h2 class="text-5xl font-bold mb-6" style="color: #264D52;">Lawar</h2>
            <p class="text-xl max-w-3xl mx-auto" style="color: #496549;">
                Hidangan tradisional Bali yang terbuat dari daging cincang, sayuran, 
                kelapa parut, dan bumbu rempah yang kaya
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-start">
            <div class="food-card rounded-3xl overflow-hidden shadow-2xl sticky top-24">
                <img src="images/lawar.jpg" alt="Lawar" class="food-image w-full h-full object-cover">
            </div>
            
            <div class="space-y-6">
                <div class="recipe-step bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-xl" style="background: linear-gradient(135deg, #496549, #264D52);">
                            1
                        </div>
                        <div>
                            <h3 class="font-bold text-xl mb-2" style="color: #264D52;">Pilih Daging</h3>
                            <p style="color: #496549;">
                                Lawar bisa dibuat dari daging babi, ayam, atau bebek. 
                                Daging dicincang halus dan dicampur dengan darah segar untuk 
                                varian lawar merah.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="recipe-step bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-xl" style="background: linear-gradient(135deg, #496549, #264D52);">
                            2
                        </div>
                        <div>
                            <h3 class="font-bold text-xl mb-2" style="color: #264D52;">Tambah Sayuran</h3>
                            <p style="color: #496549;">
                                Campurkan dengan sayuran seperti kacang panjang, nangka muda, 
                                dan kelapa parut sangrai yang memberikan tekstur renyah.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="recipe-step bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-xl" style="background: linear-gradient(135deg, #496549, #264D52);">
                            3
                        </div>
                        <div>
                            <h3 class="font-bold text-xl mb-2" style="color: #264D52;">Bumbu Khas</h3>
                            <p style="color: #496549;">
                                Gunakan base genep (bumbu dasar Bali) yang terdiri dari 
                                bawang merah, bawang putih, cabai, terasi, dan lengkuas.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="recipe-step bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-xl" style="background: linear-gradient(135deg, #496549, #264D52);">
                            4
                        </div>
                        <div>
                            <h3 class="font-bold text-xl mb-2" style="color: #264D52;">Sajikan Segar</h3>
                            <p style="color: #496549;">
                                Lawar paling nikmat dimakan segar setelah dibuat, disajikan 
                                dengan nasi putih hangat dan sambal matah.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20" style="background: linear-gradient(135deg, #7D8C9A, #496549);">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-white text-center mb-12">Kuliner Lainnya</h2>
        <div class="flex gap-8 overflow-x-auto pb-8 scrollbar-hide">
            <div class="flex-shrink-0 w-80 food-card bg-white rounded-2xl overflow-hidden shadow-xl">
                <img src="images/nasi-campur-bali.jpg" alt="Nasi Campur Bali" class="food-image w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-2" style="color: #264D52;">Nasi Campur Bali</h3>
                    <p style="color: #496549;">Nasi dengan lauk beragam khas Bali</p>
                </div>
            </div>
            <div class="flex-shrink-0 w-80 food-card bg-white rounded-2xl overflow-hidden shadow-xl">
                <img src="images/bebek-betutu-bali.jpg" alt="Bebek Betutu" class="food-image w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-2" style="color: #264D52;">Bebek Betutu</h3>
                    <p style="color: #496549;">Bebek bumbu khas yang dipanggang</p>
                </div>
            </div>
            <div class="flex-shrink-0 w-80 food-card bg-white rounded-2xl overflow-hidden shadow-xl">
                <img src="images/tipat-cantok.jpg" alt="Tipat Cantok" class="food-image w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-2" style="color: #264D52;">Tipat Cantok</h3>
                    <p style="color: #496549;">Salad sayur dengan saus kacang</p>
                </div>
            </div>
            <div class="flex-shrink-0 w-80 food-card bg-white rounded-2xl overflow-hidden shadow-xl">
                <img src="images/nasi_jinggo.jpg" alt="Ayam Betutu" class="food-image w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-2" style="color: #264D52;">Nasi Jinggo</h3>
                    <p style="color: #496549;">Nasi Kucing Khas Bali yang Lezat dan Murah Meriah</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mx-auto px-6 py-20">
    <div class="rounded-3xl p-16 text-center text-white" style="background: linear-gradient(135deg, #266C52, #496A49);">
        <h2 class="text-4xl font-bold mb-4" >Lapar? Waktunya Jelajah!</h2>
        <p class="text-xl mb-8" >Kunjungi destinasi wisata atau lihat galeri foto</p>
        <div class="flex justify-center gap-4 flex-wrap">
            <x-button href="/destinasi">
                Destinasi Wisata
            </x-button>
            <x-button href="/galeri">
                Lihat Galeri
            </x-button>
        </div>
    </div>
</section>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection