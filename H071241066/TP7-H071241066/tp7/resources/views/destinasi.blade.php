@extends('layouts.master')

@section('title', 'Destinasi Wisata - Eksplor Bali')

@section('content')
<style>
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0.5);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .destination-left {
        animation: slideInLeft 0.8s ease-out;
    }

    .destination-right {
        animation: slideInRight 0.8s ease-out;
    }

    .destination-center {
        animation: zoomIn 0.8s ease-out;
    }

    .destination-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .destination-card:hover {
        transform: scale(1.05) rotate(2deg);
    }

    .destination-card:hover .overlay {
        opacity: 0.95;
    }

    .overlay {
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .map-container {
        height: 500px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .pulse-animation {
        animation: pulse 2s ease-in-out infinite;
    }

    .hero-slider {
        position: relative;
        height: 600px;
        overflow: hidden;
    }

    .hero-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1.5s ease-in-out;
        background-size: cover;
        background-position: center;
    }

    .hero-slide.active {
        opacity: 1;
    }

    .hero-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.5));
    }

    .hero-content {
        position: relative;
        z-index: 10;
        animation: fadeIn 1s ease-out;
    }

    .hero-indicators {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 20;
    }

    .indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .indicator.active {
        background: white;
        width: 40px;
        border-radius: 6px;
    }

    .hero-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 20;
        background: rgba(255,255,255,0.3);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .hero-nav:hover {
        background: rgba(255,255,255,0.5);
        transform: translateY(-50%) scale(1.1);
    }

    .hero-nav.prev {
        left: 30px;
    }

    .hero-nav.next {
        right: 30px;
    }

    .floating-badge {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    #mapFrame {
        transition: opacity 0.3s ease;
    }
    
    .destination-item {
        transition: all 0.3s ease;
    }
    
    .destination-item:hover {
        transform: translateX(5px);
    }
</style>


<section class="relative hero-slider">

<div class="hero-slide active" style="background-image: url('images/pura_lot.jpg');">
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center text-white hero-content px-6">
            <div class="floating-badge inline-block bg-orange-500 px-6 py-2 rounded-full text-sm font-semibold mb-4">
                Pura Ikonik
            </div>
            <h1 class="text-6xl md:text-7xl font-bold mb-4 drop-shadow-2xl">Tanah Lot</h1>
            <p class="text-2xl md:text-3xl mb-2">Keajaiban Pura di Atas Batu Karang</p>
            <p class="text-lg opacity-90 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                Tabanan, Bali
            </p>
        </div>
    </div>
</div>


    <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=1920&q=80');">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white hero-content px-6">
                <div class="floating-badge inline-block bg-green-500 px-6 py-2 rounded-full text-sm font-semibold mb-4">
                 Sawah Terasering
                </div>
                <h1 class="text-6xl md:text-7xl font-bold mb-4 drop-shadow-2xl">Tegallalang</h1>
                <p class="text-2xl md:text-3xl mb-2">Hamparan Hijau Sawah Bertingkat</p>
                 <p class="text-lg opacity-90 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                Gianyar, Bali
            </p>
            </div>
        </div>
    </div>

    <div class="hero-slide" style="background-image: url('images/pura_uluwatu.jpg');">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white hero-content px-6">
                <div class="floating-badge inline-block bg-blue-500 px-6 py-2 rounded-full text-sm font-semibold mb-4">
                     Tebing & Pura
                </div>
                <h1 class="text-6xl md:text-7xl font-bold mb-4 drop-shadow-2xl">Pura Uluwatu</h1>
                <p class="text-2xl md:text-3xl mb-2">Keagungan di Tebing Karang</p>
                 <p class="text-lg opacity-90 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                Badung, Bali
            </p>
            </div>
        </div>
    </div>

    <div class="hero-slide" style="background-image: url('images/nuspen.webp');">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white hero-content px-6">
                <div class="floating-badge inline-block bg-cyan-500 px-6 py-2 rounded-full text-sm font-semibold mb-4">
                     Pulau Eksotis
                </div>
                <h1 class="text-6xl md:text-7xl font-bold mb-4 drop-shadow-2xl">Nusa Penida</h1>
                <p class="text-2xl md:text-3xl mb-2">Surga Tersembunyi di Selatan Bali</p>
                 <p class="text-lg opacity-90 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                Klungkung, Bali
            </p>
            </div>
        </div>
    </div>

    <div class="hero-slide" style="background-image: url('images/batur.jpg');">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white hero-content px-6">
                <div class="floating-badge inline-block bg-red-500 px-6 py-2 rounded-full text-sm font-semibold mb-4">
                     Gunung Berapi
                </div>
                <h1 class="text-6xl md:text-7xl font-bold mb-4 drop-shadow-2xl">Gunung Batur</h1>
                <p class="text-2xl md:text-3xl mb-2">Sunrise Trekking Spektakuler</p>
                 <p class="text-lg opacity-90 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                Kintamani, Bali
            </p>
            </div>
        </div>
    </div>

    <div class="hero-nav prev" onclick="changeSlide(-1)">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
        </svg>
    </div>
    <div class="hero-nav next" onclick="changeSlide(1)">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
        </svg>
    </div>

    <div class="hero-indicators">
        <div class="indicator active" onclick="goToSlide(0)"></div>
        <div class="indicator" onclick="goToSlide(1)"></div>
        <div class="indicator" onclick="goToSlide(2)"></div>
        <div class="indicator" onclick="goToSlide(3)"></div>
        <div class="indicator" onclick="goToSlide(4)"></div>
    </div>
</section>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.indicator');
    let slideInterval;

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        slides[index].classList.add('active');
        indicators[index].classList.add('active');
    }

    function changeSlide(direction) {
        currentSlide += direction;
        if (currentSlide >= slides.length) currentSlide = 0;
        else if (currentSlide < 0) currentSlide = slides.length - 1;
        showSlide(currentSlide);
        resetInterval();
    }

    function goToSlide(index) {
        currentSlide = index;
        showSlide(currentSlide);
        resetInterval();
    }

    function autoSlide() {
        currentSlide++;
        if (currentSlide >= slides.length) currentSlide = 0;
        showSlide(currentSlide);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(autoSlide, 5000);
    }

    slideInterval = setInterval(autoSlide, 5000);

    document.querySelector('.hero-slider').addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
    });

    document.querySelector('.hero-slider').addEventListener('mouseleave', () => {
        resetInterval();
    });
</script>

<section class="container mx-auto px-6 py-20">
    <div class="grid md:grid-cols-2 gap-12 items-center mb-32">
        <div class="destination-left">
            <div class="relative destination-card rounded-3xl overflow-hidden shadow-2xl">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80" alt="Tanah Lot" class="w-full h-96 object-cover">
                <div class="overlay absolute inset-0 bg-gradient-to-t from-black to-transparent flex items-end p-8">
                    <div class="text-white">
                        <span class="bg-orange-500 px-4 py-1 rounded-full text-sm">Pura Ikonik</span>
                        <h3 class="text-3xl font-bold mt-2">Tanah Lot</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="destination-right">
             <p class="text-lg opacity-90 flex  gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                Tabanan, Bali
            </p>
            <h2 class="text-4xl font-bold text-gray-800 mt-2 mb-6">Pura di Atas Batu Karang</h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                Tanah Lot adalah salah satu pura paling ikonik di Bali. Terletak di atas 
                formasi batu karang besar yang dikelilingi ombak Samudra Hindia, pura ini 
                menawarkan pemandangan sunset yang spektakuler. Dibangun pada abad ke-16, 
                Tanah Lot menjadi tempat pemujaan Dewa Laut dan merupakan salah satu dari 
                tujuh pura laut di pesisir Bali.
            </p>
            <div class="flex items-center gap-4 text-gray-600">
                <div class="flex items-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>

                    <span>Best: 17:00 - 19:00</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
</svg>
                    <span>Rp 60.000</span>
                </div>
            </div>
        </div>
    </div>


    <div class="grid md:grid-cols-2 gap-12 items-center mb-32">
        <div class="destination-left order-2 md:order-1">
            <p class="text-lg opacity-90 flex  gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                Gianyar, Bali
            </p>
            <h2 class="text-4xl font-bold text-gray-800 mt-2 mb-6">Sawah Terasering Tegallalang</h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                Tegallalang Rice Terrace adalah destinasi yang wajib dikunjungi untuk 
                melihat sistem irigasi subak tradisional Bali yang telah diakui UNESCO. 
                Hamparan sawah bertingkat yang hijau membentang indah, menciptakan 
                pemandangan yang sangat fotogenik. Pengunjung dapat berjalan menyusuri 
                jalan setapak di antara sawah sambil menikmati keindahan alam pedesaan Bali.
            </p>
            <div class="flex items-center gap-4 text-gray-600">
                <div class="flex items-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>

                    <span>Best: 06:00 - 10:00</span>
                </div>
                <div class="flex items-center gap-2">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
</svg>

                    <span>Rp 20.000</span>
                </div>
            </div>
        </div>
        <div class="destination-right order-1 md:order-2">
            <div class="relative destination-card rounded-3xl overflow-hidden shadow-2xl">
                <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=800&q=80" alt="Tegallalang" class="w-full h-96 object-cover">
                <div class="overlay absolute inset-0 bg-gradient-to-t from-black to-transparent flex items-end p-8">
                    <div class="text-white">
                        <span class="bg-green-500 px-4 py-1 rounded-full text-sm">Alam</span>
                        <h3 class="text-3xl font-bold mt-2">Tegallalang</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="text-center mb-32">
        <div class="destination-center mb-12">
            <div class="relative inline-block">
                <div class="w-80 h-80 rounded-full overflow-hidden shadow-2xl destination-card pulse-animation mx-auto">
                    <img src="https://images.unsplash.com/photo-1570789210967-2cac24afeb00?w=800&q=80" alt="Nusa Penida" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-white px-6 py-3 rounded-full shadow-lg">
                    <span class="text-cyan-600 font-bold text-lg">Nusa Penida</span>
                </div>
            </div>
        </div>
        <p class="text-lg opacity-90 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                Klungkung, Bali
            </p>
        <h2 class="text-4xl font-bold text-gray-800 mt-2 mb-6">Surga Tersembunyi</h2>
        <p class="text-gray-600 text-lg leading-relaxed max-w-3xl mx-auto">
            Nusa Penida adalah pulau kecil yang terletak di sebelah tenggara Bali, 
            menawarkan keindahan alam yang masih sangat alami. Pantai Kelingking dengan 
            tebingnya yang berbentuk seperti T-Rex, Angel's Billabong dengan kolam alami 
            di tepi tebing, dan Broken Beach dengan arch batu karang yang unik adalah 
            beberapa spot yang wajib dikunjungi.
        </p>
    </div>
</section>

<section class="bg-gray-100 py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12 destination-center">
            <h2 class="text-5xl font-bold text-gray-800 mb-4">Peta Lokasi Destinasi</h2>
            <p class="text-xl text-gray-600">Klik destinasi untuk melihat lokasi di peta</p>
        </div>
        
        <div class="grid md:grid-cols-5 gap-6">
            <div class="md:col-span-2 space-y-4">
                <div class="destination-item bg-white rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-2xl transition-all duration-300 border-l-4 border-transparent hover:border-orange-500"
                     data-location="tanah-lot"
                     onclick="changeMap('tanah-lot')">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Tanah Lot</h3>
                            <p class="text-sm text-gray-600 mb-2">Tabanan, Bali</p>
                            <p class="text-gray-500 text-sm">Pura ikonik di atas batu karang dengan pemandangan sunset menakjubkan</p>
                        </div>
                        <div class="text-orange-500 text-2xl">→</div>
                    </div>
                </div>

                <div class="destination-item bg-white rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-2xl transition-all duration-300 border-l-4 border-transparent hover:border-green-500"
                     data-location="tegallalang"
                     onclick="changeMap('tegallalang')">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Tegallalang</h3>
                            <p class="text-sm text-gray-600 mb-2">Gianyar, Bali</p>
                            <p class="text-gray-500 text-sm">Sawah terasering dengan pemandangan hijau yang memukau</p>
                        </div>
                        <div class="text-green-500 text-2xl">→</div>
                    </div>
                </div>

                <div class="destination-item bg-white rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-2xl transition-all duration-300 border-l-4 border-transparent hover:border-blue-500"
                     data-location="uluwatu"
                     onclick="changeMap('uluwatu')">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Pura Uluwatu</h3>
                            <p class="text-sm text-gray-600 mb-2">Badung, Bali</p>
                            <p class="text-gray-500 text-sm">Pura megah di tebing setinggi 70 meter dengan pertunjukan Kecak</p>
                        </div>
                        <div class="text-blue-500 text-2xl">→</div>
                    </div>
                </div>

                <div class="destination-item bg-white rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-2xl transition-all duration-300 border-l-4 border-transparent hover:border-cyan-500"
                     data-location="nusa-penida"
                     onclick="changeMap('nusa-penida')">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Nusa Penida</h3>
                            <p class="text-sm text-gray-600 mb-2">Klungkung, Bali</p>
                            <p class="text-gray-500 text-sm">Pulau dengan pantai Kelingking dan pemandangan alam yang menakjubkan</p>
                        </div>
                        <div class="text-cyan-500 text-2xl">→</div>
                    </div>
                </div>

                <div class="destination-item bg-white rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-2xl transition-all duration-300 border-l-4 border-transparent hover:border-purple-500"
                     data-location="ubud"
                     onclick="changeMap('ubud')">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Ubud Monkey Forest</h3>
                            <p class="text-sm text-gray-600 mb-2">Ubud, Gianyar</p>
                            <p class="text-gray-500 text-sm">Hutan sakral dengan ratusan monyet dan pura kuno</p>
                        </div>
                        <div class="text-purple-500 text-2xl">→</div>
                    </div>
                </div>

                <div class="destination-item bg-white rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-2xl transition-all duration-300 border-l-4 border-transparent hover:border-red-500"
                     data-location="batur"
                     onclick="changeMap('batur')">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Gunung Batur</h3>
                            <p class="text-sm text-gray-600 mb-2">Kintamani, Bangli</p>
                            <p class="text-gray-500 text-sm">Gunung berapi aktif dengan sunrise trekking yang spektakuler</p>
                        </div>
                        <div class="text-red-500 text-2xl">→</div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-3">
                <div class="map-container sticky top-24">
                    <iframe 
                        id="mapFrame"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.2076181474554!2d115.09845631478322!3d-8.670458893755956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2409b0e5e80db%3A0xe27334e8ccb9374a!2sTanah%20Lot!5e0!3m2!1sen!2sid!4v1635789012345!5m2!1sen!2sid"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                    <div class="mt-4 text-center">
                        <p id="mapTitle" class="text-lg font-bold text-gray-800">📍 Tanah Lot</p>
                        <p class="text-sm text-gray-600 mt-1">Klik destinasi di sebelah kiri untuk melihat lokasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const mapData = {
        'tanah-lot': {
            url: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.2076181474554!2d115.09845631478322!3d-8.670458893755956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2409b0e5e80db%3A0xe27334e8ccb9374a!2sTanah%20Lot!5e0!3m2!1sen!2sid!4v1635789012345!5m2!1sen!2sid',
            title: '📍 Tanah Lot - Pura Ikonik di Tepi Laut'
        },
        'tegallalang': {
            url: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.3927428815!2d115.27634631478145!3d-8.432883893732883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd21f8a8e2e85a5%3A0x2872c6b6b3b4e53!2sTegalalang%20Rice%20Terrace!5e0!3m2!1sen!2sid!4v1635789012345!5m2!1sen!2sid',
            title: '📍 Tegallalang - Sawah Terasering UNESCO'
        },
        'uluwatu': {
            url: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.675879896494!2d115.08265731478457!3d-8.829134293787265!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd25fafe0a23d59%3A0x5023fbbfed1e696f!2sUluwatu%20Temple!5e0!3m2!1sen!2sid!4v1635789012345!5m2!1sen!2sid',
            title: '📍 Pura Uluwatu - Keagungan di Tebing'
        },
        'nusa-penida': {
            url: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63144.67836082656!2d115.47968862167969!3d-8.723169999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd25e0e22e5c39f%3A0x5a6e8dda14d1b92f!2sKelingking%20Beach!5e0!3m2!1sen!2sid!4v1635789012345!5m2!1sen!2sid',
            title: '📍 Nusa Penida - Kelingking Beach'
        },
        'ubud': {
            url: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.668721890817!2d115.25695131478118!3d-8.517154293739956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23d738a839d07%3A0x61c3b20a38f0a95d!2sSacred%20Monkey%20Forest%20Sanctuary!5e0!3m2!1sen!2sid!4v1635789012345!5m2!1sen!2sid',
            title: '📍 Ubud Monkey Forest - Hutan Sakral'
        },
        'batur': {
            url: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.2716815819194!2d115.37518531477986!3d-8.24245493717726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1f7e9fc6c8041%3A0xf843355e83702c35!2sMount%20Batur!5e0!3m2!1sen!2sid!4v1635789012345!5m2!1sen!2sid',
            title: '📍 Gunung Batur - Sunrise Trekking'
        }
    };

    function changeMap(location) {
        const mapFrame = document.getElementById('mapFrame');
        const mapTitle = document.getElementById('mapTitle');
        const data = mapData[location];
        
        if (data) {
            mapFrame.style.opacity = '0';
            
            setTimeout(() => {
                mapFrame.src = data.url;
                mapTitle.textContent = data.title;
                mapFrame.style.opacity = '1';
            }, 300);
            
            document.querySelectorAll('.destination-item').forEach(item => {
                item.classList.remove('ring-2', 'ring-offset-2', 'ring-orange-500', 'ring-green-500', 'ring-blue-500', 'ring-cyan-500', 'ring-purple-500', 'ring-red-500');
                if (item.dataset.location === location) {
                    item.classList.add('ring-2', 'ring-offset-2');
                    
                    if (location === 'tanah-lot') item.classList.add('ring-orange-500');
                    if (location === 'tegallalang') item.classList.add('ring-green-500');
                    if (location === 'uluwatu') item.classList.add('ring-blue-500');
                    if (location === 'nusa-penida') item.classList.add('ring-cyan-500');
                    if (location === 'ubud') item.classList.add('ring-purple-500');
                    if (location === 'batur') item.classList.add('ring-red-500');
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const firstItem = document.querySelector('.destination-item[data-location="tanah-lot"]');
        if (firstItem) {
            firstItem.classList.add('ring-2', 'ring-offset-2', 'ring-orange-500');
        }
    });
</script>

<section class="container mx-auto px-6 py-20">
    <div class="rounded-3xl p-16 text-center text-white" style="background: linear-gradient(135deg, #266C52, #496A49);">
        <h2 class="text-4xl font-bold mb-4">Masih Banyak Destinasi Lainnya!</h2>
        <p class="text-xl mb-8">Lihat galeri foto atau cek kuliner khas Bali</p>
        <div class="flex justify-center gap-4">
            <x-button href="/kuliner">
                Cicipi Kuliner
            </x-button>
            <x-button href="/galeri">
                Lihat Galeri
            </x-button>
        </div>
    </div>
</section>
@endsection