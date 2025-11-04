@extends('layouts.master')

@section('title', 'Galeri Foto - Eksplor Bali')

@section('content')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .gallery-item {
        animation: fadeIn 0.6s ease-out backwards;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
    }

    .gallery-item:nth-child(1) { animation-delay: 0.1s; }
    .gallery-item:nth-child(2) { animation-delay: 0.2s; }
    .gallery-item:nth-child(3) { animation-delay: 0.3s; }
    .gallery-item:nth-child(4) { animation-delay: 0.4s; }
    .gallery-item:nth-child(5) { animation-delay: 0.5s; }
    .gallery-item:nth-child(6) { animation-delay: 0.6s; }

    .gallery-item:hover {
        transform: scale(1.05) translateY(-10px);
        z-index: 10;
    }

    .masonry {
        column-count: 3;
        column-gap: 1.5rem;
    }

    .masonry-item {
        break-inside: avoid;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .masonry {
            column-count: 2;
        }
    }

    @media (max-width: 480px) {
        .masonry {
            column-count: 1;
        }
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.95);
        animation: fadeIn 0.3s ease;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        max-width: 90%;
        max-height: 90vh;
        object-fit: contain;
        animation: fadeIn 0.5s ease;
    }

    @keyframes slideInFromLeft {
        from {
            opacity: 0;
            transform: translateX(-100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInFromRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .category-badge {
        transition: all 0.3s ease;
    }

    .category-badge:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .polaroid {
        background: white;
        padding: 1rem;
        padding-bottom: 3rem;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transform: rotate(0deg);
        transition: all 0.3s ease;
    }

    .polaroid:hover {
        transform: rotate(5deg) scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }
</style>

<section class="relative h-96 flex items-center justify-center overflow-hidden">
    <video autoplay loop playsinline class="absolute inset-0 w-full h-full object-cover">
        <source src="images/video.mp4" type="video/mp4">
        Browser Anda tidak mendukung video tag.
    </video>

    <div class="absolute inset-0 bg-black bg-opacity-40"></div>

    <div class="text-center z-10" style="color: #D8C0AA;">
        <h1 class="text-6xl font-bold mb-4">Galeri Bali</h1>
        <p class="text-2xl">Keindahan dalam Setiap Bidikan</p>
    </div>
</section>


<section class="container mx-auto px-6 py-12">
    <div class="flex flex-wrap justify-center gap-4">
        <button class="category-badge px-6 py-3 text-white rounded-full font-semibold shadow-lg" style="background-color: #264D52;" onclick="filterGallery('all')">
            Semua
        </button>
        <button class="category-badge px-6 py-3 text-white rounded-full font-semibold shadow-lg" style="background-color: #496549;" onclick="filterGallery('nature')">
            Alam
        </button>
        <button class="category-badge px-6 py-3 text-white rounded-full font-semibold shadow-lg" style="background-color: #7D8C9A;" onclick="filterGallery('culture')">
            Budaya
        </button>
        <button class="category-badge px-6 py-3 rounded-full font-semibold shadow-lg" style="background-color: #C59F82; color: #264D52;" onclick="filterGallery('beach')">
            Pantai
        </button>
        <button class="category-badge px-6 py-3 rounded-full font-semibold shadow-lg" style="background-color: #D8C0AA; color: #264D52;" onclick="filterGallery('landmark')">
            Landmark
        </button>
    </div>
</section>

<section class="container mx-auto px-6 py-12">
    <div class="masonry">
        <div class="masonry-item gallery-item" data-category="nature">
            <div class="polaroid">
                <img src="images/tegallalang2.jpg" alt="Sawah Tegallalang" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Sawah Tegallalang</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="beach">
            <div class="polaroid">
                <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&q=80" alt="Kelingking Beach" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Kelingking Beach</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="landmark">
            <div class="polaroid">
                <img src="images/tanah-lot.jpg" alt="Tanah Lot Sunset" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Tanah Lot Sunset</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="culture">
            <div class="polaroid">
                <img src="images/tarikecak.jpg" alt="Tari Kecak" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Tari Kecak Uluwatu</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="nature">
            <div class="polaroid">
                <img src="images/sunrise.jpg" alt="Gunung Batur" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Sunrise Gunung Batur</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="beach">
            <div class="polaroid">
                <img src="images/pantai-nusa-dua.jpg" alt="Pantai Nusa Dua" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Pantai Nusa Dua</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="landmark">
            <div class="polaroid">
                <img src="images/pura_empul.jpg" alt="Tirta Empul" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Pura Tirta Empul</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="culture">
            <div class="polaroid">
                <img src="images/tari_barong.jpg" alt="Tari Barong" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Tari Barong</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="nature">
            <div class="polaroid">
                <img src="images/jatiluwuh.jpg" alt="Jatiluwih" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Jatiluwih Rice Terrace</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="beach">
            <div class="polaroid">
                <img src="images/sunrisesanur.jpg" alt="Pantai Sanur" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Sunrise Pantai Sanur</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="landmark">
            <div class="polaroid">
                <img src="images/handara_gate.jpg" alt="Handara Gate" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Handara Gate</p>
            </div>
        </div>

        <div class="masonry-item gallery-item" data-category="culture">
            <div class="polaroid">
                <img src="images/canang_sari.jpg" alt="Canang Sari" class="w-full rounded" onclick="openModal(this)">
                <p class="text-center mt-3 font-semibold" style="color: #264D52;">Canang Sari</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20" style="background: linear-gradient(135deg, #264D52, #496549);">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 text-center" style="color: #D8C0AA;">
            <div>
                <div class="text-5xl font-bold mb-2">500+</div>
                <div class="text-xl opacity-90">Destinasi Wisata</div>
            </div>
            <div>
                <div class="text-5xl font-bold mb-2">50+</div>
                <div class="text-xl opacity-90">Kuliner Khas</div>
            </div>
            <div>
                <div class="text-5xl font-bold mb-2">100+</div>
                <div class="text-xl opacity-90">Pura & Candi</div>
            </div>
            <div>
                <div class="text-5xl font-bold mb-2">1000+</div>
                <div class="text-xl opacity-90">Pengalaman Unik</div>
            </div>
        </div>
    </div>
</section>


<div id="imageModal" class="modal" onclick="closeModal()">
    <span class="absolute top-8 right-8 text-5xl font-bold cursor-pointer hover:text-gray-300 z-10" style="color: #D8C0AA;">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<section class="container mx-auto px-6 py-20">
    <div class="rounded-3xl p-16 text-center text-white" style="background: linear-gradient(135deg, #266C52, #496A49);">
        <h2 class="text-4xl font-bold mb-4" >Tertarik Berkunjung?</h2>
        <p class="text-xl mb-8" >Hubungi kami untuk informasi lebih lanjut</p>
        <x-button href="/kontak">
            Hubungi Kami
        </x-button>
    </div>
</section>

<script>
    function filterGallery(category) {
        const items = document.querySelectorAll('.gallery-item');
        
        items.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.6s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function openModal(img) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.classList.add('active');
        modalImg.src = img.src;
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endsection