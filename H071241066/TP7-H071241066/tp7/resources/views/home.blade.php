@extends('layouts.master')

@section('title', 'Home - Eksplor Bali')

@section('content')
<style>

    .scrolling-text-container {
        overflow: hidden;
        height: 6rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .scrolling-text-wrapper {
        animation: slide-fade 5.6s ease-in-out infinite;
    }

    @keyframes slide-fade {
        0% {
            transform: translateY(-100%);
            opacity: 0;
        }
        20% {
            transform: translateY(0);
            opacity: 1;
        }
        80% {
            transform: translateY(0);
            opacity: 1;
        }
        100% {
            transform: translateY(100%);
            opacity: 0;
        }
    }

    @media (min-width: 768px) {
        .scrolling-text-container {
            height: 12rem;
        }
    }

    .hero-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        pointer-events: none;
    }

    .hero-slide.active {
        opacity: 1;
        pointer-events: auto;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 1s ease-out;
    }

    .icon-hover {
        transition: transform 0.3s ease;
    }

    .icon-hover:hover {
        transform: scale(1.1);
    }
</style>


<section class="relative h-screen overflow-hidden">
    <div class="hero-slide active" data-slide="1">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920&q=80" 
                 alt="Tanah Lot" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="relative h-full flex items-center justify-center text-center text-white px-6">
            <div class="fade-in-up w-full">
                <div class="scrolling-text-container mb-6">
                    <div class="scrolling-text-wrapper">
                        <h1 class="text-6xl md:text-8xl font-bold">Om Swastiastu</h1>
                    </div>
                </div>
                <p class="text-2xl md:text-3xl mb-8">Selamat Datang di Pulau Dewata</p>
                <x-button href="/destinasi">
                    Jelajahi Destinasi
                </x-button>
            </div>
        </div>
    </div>

    <div class="hero-slide" data-slide="2">
        <div class="absolute inset-0">
            <img src="images/wisata-religi.jpg" 
                 alt="Pura Besakih" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="relative h-full flex items-center justify-center text-center text-white px-6">
            <div class="fade-in-up w-full">
                <div class="scrolling-text-container mb-6">
                    <div class="scrolling-text-wrapper">
                        <h1 class="text-6xl md:text-8xl font-bold">Wisata Religi</h1>
                    </div>
                </div>
                <p class="text-2xl md:text-3xl mb-8">Temukan Kedamaian Spiritual</p>
                <x-button href="/destinasi">
                    Kunjungi Pura Suci
                </x-button>
            </div>
        </div>
    </div>

    <div class="hero-slide" data-slide="3">
        <div class="absolute inset-0">
            <img src="images/pantai-eksotis.jpg" 
                 alt="Pantai Bali" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="relative h-full flex items-center justify-center text-center text-white px-6">
            <div class="fade-in-up w-full">
                <div class="scrolling-text-container mb-6">
                    <div class="scrolling-text-wrapper">
                        <h1 class="text-6xl md:text-8xl font-bold">Pantai Eksotis</h1>
                    </div>
                </div>
                <p class="text-2xl md:text-3xl mb-8">Nikmati Keindahan Laut Tropis</p>
                <x-button href="/destinasi">
                    Lihat Pantai
                </x-button>
            </div>
        </div>
    </div>

    <div class="hero-slide" data-slide="4">
        <div class="absolute inset-0">
            <img src="images/budaya-bali.jpg" 
                 alt="Budaya Bali" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="relative h-full flex items-center justify-center text-center text-white px-6">
            <div class="fade-in-up w-full">
                <div class="scrolling-text-container mb-6">
                    <div class="scrolling-text-wrapper">
                        <h1 class="text-6xl md:text-8xl font-bold">Budaya Bali</h1>
                    </div>
                </div>
                <p class="text-2xl md:text-3xl mb-8">Rasakan Kekayaan Tradisi Nusantara</p>
                <x-button href="/galeri">
                    Jelajahi Budaya
                </x-button>
            </div>
        </div>
    </div>


    <div class="hero-slide" data-slide="5">
        <div class="absolute inset-0">
            <img src="images/kuliner-bali.jpg" 
                 alt="Kuliner Bali" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="relative h-full flex items-center justify-center text-center text-white px-6">
            <div class="fade-in-up w-full">
                <div class="scrolling-text-container mb-6">
                    <div class="scrolling-text-wrapper">
                        <h1 class="text-6xl md:text-8xl font-bold">Kuliner Khas</h1>
                    </div>
                </div>
                <p class="text-2xl md:text-3xl mb-8">Cicipi Kelezatan Cita Rasa Bali</p>
                <x-button href="/kuliner">
                    Eksplorasi Kuliner
                </x-button>
            </div>
        </div>
    </div>


    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-10">
        <button class="slide-dot w-3 h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-slide="1"></button>
        <button class="slide-dot w-3 h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-slide="2"></button>
        <button class="slide-dot w-3 h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-slide="3"></button>
        <button class="slide-dot w-3 h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-slide="4"></button>
        <button class="slide-dot w-3 h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-slide="5"></button>
    </div>
</section>


<section class="container mx-auto px-6 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Tentang Bali</h2>
        <div class="w-24 h-1 mx-auto" style="background-color: #496A49;"></div>
    </div>

    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
            <img src="images/bali-landscape.jpg" 
                 alt="Bali Landscape" 
                 class="rounded-2xl shadow-2xl">
        </div>
        <div>
            <h3 class="text-3xl font-bold text-gray-800 mb-6">Pulau Dewata yang Memukau</h3>
            <p class="text-gray-600 leading-relaxed mb-4">
                Bali, yang dikenal sebagai Pulau Dewata, adalah destinasi wisata kelas dunia yang menawarkan perpaduan sempurna antara keindahan alam yang memesona, kebudayaan Hindu yang kental, dan suasana spiritual yang menenangkan jiwa.
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">
                Dari pantai-pantai eksotis dengan pasir putih yang lembut, pura-pura megah yang menjulang di atas tebing, hingga sawah-sawah terasering yang hijau membentang, Bali menyajikan pengalaman yang tak terlupakan bagi setiap pengunjung.
            </p>
            <p class="text-gray-600 leading-relaxed mb-6">
                Keramahan penduduk lokal, seni dan budaya yang hidup, serta kuliner khas yang menggugah selera menjadikan Bali sebagai surga tropis yang wajib dikunjungi. Bali bukan hanya tempat liburan, tetapi juga pusat healing dan spiritual yang menyembuhkan.
            </p>
            <x-button href="/destinasi">
                Mulai Petualangan
            </x-button>
        </div>
    </div>
</section>


<section class="py-16" style="background-color: #f5f5f4;">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Mengapa Bali?</h2>
            <div class="w-24 h-1 mx-auto" style="background-color: #496A49;"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center" style="border-top: 4px solid #70AC90;">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 icon-hover" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3" style="color: #264D52;">Pantai Menawan</h3>
                <p class="text-gray-600">Pantai-pantai indah dengan pasir putih, ombak sempurna untuk berselancar, dan sunset yang memukau.</p>
            </div>


            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center" style="border-top: 4px solid #70AC90;">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 icon-hover" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3" style="color: #264D52;">Spiritual & Religi</h3>
                <p class="text-gray-600">Ribuan pura suci yang megah, upacara keagamaan yang sakral, dan energi spiritual yang kuat.</p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center" style="border-top: 4px solid #70AC90;">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 icon-hover" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3" style="color: #264D52;">Kuliner Lezat</h3>
                <p class="text-gray-600">Hidangan khas Bali yang kaya rempah, dari Babi Guling hingga Ayam Betutu yang legendaris.</p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center" style="border-top: 4px solid #70AC90;">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 icon-hover" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3" style="color: #264D52;">Seni & Budaya</h3>
                <p class="text-gray-600">Tarian tradisional, musik gamelan, ukiran kayu, dan kerajinan perak yang memukau.</p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center" style="border-top: 4px solid #70AC90;">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 icon-hover" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3" style="color: #264D52;">Alam Menakjubkan</h3>
                <p class="text-gray-600">Sawah terasering, gunung berapi, air terjun tersembunyi, dan hutan hijau yang menyejukkan.</p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center" style="border-top: 4px solid #70AC90;">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 icon-hover" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3" style="color: #264D52;">Keramahan Lokal</h3>
                <p class="text-gray-600">Masyarakat yang ramah, senyuman hangat, dan kebudayaan gotong royong yang kental.</p>
            </div>
        </div>
    </div>
</section>

<section class="container mx-auto px-6 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Mulai Eksplorasi</h2>
        <div class="w-24 h-1 mx-auto" style="background-color: #496A49;"></div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="/destinasi" class="group">
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="images/nusa-penida.jpg" 
                         alt="Destinasi" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800">Destinasi Wisata</h3>
                    <p class="mt-2" style="color: #496A49;">Lihat Destinasi →</p>
                </div>
            </div>
        </a>

        <a href="/kuliner" class="group">
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="images/home.jpg" 
                         alt="Kuliner" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800">Kuliner Khas</h3>
                    <p class="mt-2" style="color: #496A49;">Jelajahi Kuliner →</p>
                </div>
            </div>
        </a>

        <a href="/galeri" class="group">
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="images/bali-home.jpg" 
                         alt="Galeri" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800">Galeri Foto</h3>
                    <p class="mt-2" style="color: #496A49;">Lihat Galeri →</p>
                </div>
            </div>
        </a>

        <a href="/kontak" class="group">
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="images/call-us.jpg" 
                         alt="Kontak" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800">Hubungi Kami</h3>
                    <p class="mt-2" style="color: #496A49;">Kontak Kami →</p>
                </div>
            </div>
        </a>
    </div>
</section>

<script>
    let currentSlide = 1;
    const totalSlides = 5;
    let slideInterval;

    function showSlide(slideNumber) {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slide-dot');
        
        slides.forEach(slide => {
            slide.classList.remove('active');
        });
        
        dots.forEach(dot => {
            dot.classList.remove('opacity-100');
            dot.classList.add('opacity-50');
        });
        
        const targetSlide = document.querySelector(`.hero-slide[data-slide="${slideNumber}"]`);
        const targetDot = document.querySelector(`.slide-dot[data-slide="${slideNumber}"]`);
        
        if (targetSlide) {
            targetSlide.classList.add('active');
        }
        
        if (targetDot) {
            targetDot.classList.remove('opacity-50');
            targetDot.classList.add('opacity-100');
        }
        
        currentSlide = slideNumber;
    }

    function nextSlide() {
        let next = currentSlide + 1;
        if (next > totalSlides) {
            next = 1;
        }
        showSlide(next);
    }

    function startSlider() {
        slideInterval = setInterval(nextSlide, 4000);
    }

    function stopSlider() {
        clearInterval(slideInterval);
    }


    showSlide(1);
    startSlider();

    document.querySelectorAll('.slide-dot').forEach(dot => {
        dot.addEventListener('click', function() {
            stopSlider();
            const slideNumber = parseInt(this.getAttribute('data-slide'));
            showSlide(slideNumber);
            startSlider();
        });
    });

    const heroSection = document.querySelector('section.relative.h-screen');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', stopSlider);
        heroSection.addEventListener('mouseleave', startSlider);
    }
</script>
@endsection