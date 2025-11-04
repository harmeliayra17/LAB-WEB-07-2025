@extends('layouts.master')

@section('title', 'Kontak - Eksplor Bali')

@section('content')
<style>
    @keyframes slideInFromBottom {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }



    .contact-card {
        animation: slideInFromBottom 0.8s ease-out backwards;
    }

    .contact-card:nth-child(1) { animation-delay: 0.1s; }
    .contact-card:nth-child(2) { animation-delay: 0.2s; }
    .contact-card:nth-child(3) { animation-delay: 0.3s; }
    .contact-card:nth-child(4) { animation-delay: 0.4s; }

    .form-container {
        animation: slideInFromBottom 0.8s ease-out 0.5s backwards;
    }

    .contact-icon {
        transition: all 0.3s ease;
    }

    .contact-card:hover .contact-icon {
        animation: bounce 0.6s ease;
    }


    .input-field {
        transition: all 0.3s ease;
    }

    .input-field:focus {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(38, 108, 82, 0.2);
    }

    .submit-button {
        transition: all 0.3s ease;
    }

    .submit-button:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(38, 108, 82, 0.4);
    }

    .floating-shape {
        position: absolute;
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }

    .map-container {
        height: 450px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .social-icon {
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        transform: scale(1.1) rotate(5deg);
    }
</style>

<section class="relative h-96 flex items-center justify-center overflow-hidden" style="background-color: #266C52;">
    <div class="floating-shape w-64 h-64 rounded-full top-10 left-10" style="background-color: #C59F82;"></div>
    <div class="floating-shape w-40 h-40 rounded-full bottom-20 right-20" style="background-color: #D8C0AA; animation-delay: 2s;"></div>
    <div class="text-center z-10" style="color: #D8C0AA;">
        <h1 class="text-6xl font-bold mb-4 flex items-center justify-center gap-4">
            Hubungi Kami 
        </h1>
        <p class="text-2xl">Kami Siap Membantu Perjalanan Anda</p>
    </div>
</section>

<section class="container mx-auto px-6 py-20">
    <div class="grid md:grid-cols-4 gap-8">
        <div class="contact-card bg-white rounded-2xl p-8 shadow-xl text-center hover:shadow-2xl transition-all">
            <div class="contact-icon mb-4 flex justify-center">
                <svg class="w-16 h-16" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2" style="color: #266C52;">Telepon</h3>
            <p style="color: #496A49;">+62 361 123 4567</p>
            <p style="color: #496A49;">+62 812 3456 7890</p>
        </div>

        <div class="contact-card bg-white rounded-2xl p-8 shadow-xl text-center hover:shadow-2xl transition-all">
            <div class="contact-icon mb-4 flex justify-center">
                <svg class="w-16 h-16" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2" style="color: #266C52;">Email</h3>
            <p style="color: #496A49;">info@explorbali.com</p>
            <p style="color: #496A49;">tour@explorbali.com</p>
        </div>

        <div class="contact-card bg-white rounded-2xl p-8 shadow-xl text-center hover:shadow-2xl transition-all">
            <div class="contact-icon mb-4 flex justify-center">
                <svg class="w-16 h-16" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2" style="color: #266C52;">Alamat</h3>
            <p style="color: #496A49;">Jl. Raya Ubud No. 88</p>
            <p style="color: #496A49;">Ubud, Gianyar, Bali</p>
        </div>

        <div class="contact-card bg-white rounded-2xl p-8 shadow-xl text-center hover:shadow-2xl transition-all">
            <div class="contact-icon mb-4 flex justify-center">
                <svg class="w-16 h-16" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2" style="color: #266C52;">Jam Kerja</h3>
            <p style="color: #496A49;">Senin - Sabtu</p>
            <p style="color: #496A49;">08:00 - 20:00 WITA</p>
        </div>
    </div>
</section>

<section class="container mx-auto px-6 py-20">
    <div class="grid md:grid-cols-2 gap-16">
        <div class="form-container">
            <div class="bg-white rounded-3xl p-10 shadow-2xl">
                <h2 class="text-4xl font-bold mb-6" style="color: #266C52;">Kirim Pesan</h2>
                <p class="mb-8" style="color: #496A49;">
                    Punya pertanyaan? Isi form di bawah dan kami akan menghubungi Anda segera!
                </p>

                <form class="space-y-6">
                    <div>
                        <label class="block font-semibold mb-2" style="color: #266C52;">Nama Lengkap</label>
                        <input 
                            type="text" 
                            class="input-field w-full px-6 py-4 border-2 rounded-xl focus:outline-none"
                            style="border-color: #D8C0AA;"
                            placeholder="Masukkan nama Anda"
                            onfocus="this.style.borderColor='#266C52'"
                            onblur="this.style.borderColor='#D8C0AA'"
                        >
                    </div>

                    <div>
                        <label class="block font-semibold mb-2" style="color: #266C52;">Email</label>
                        <input 
                            type="email" 
                            class="input-field w-full px-6 py-4 border-2 rounded-xl focus:outline-none"
                            style="border-color: #D8C0AA;"
                            placeholder="nama@email.com"
                            onfocus="this.style.borderColor='#266C52'"
                            onblur="this.style.borderColor='#D8C0AA'"
                        >
                    </div>

                    <div>
                        <label class="block font-semibold mb-2" style="color: #266C52;">Nomor Telepon</label>
                        <input 
                            type="tel" 
                            class="input-field w-full px-6 py-4 border-2 rounded-xl focus:outline-none"
                            style="border-color: #D8C0AA;"
                            placeholder="+62 812 3456 7890"
                            onfocus="this.style.borderColor='#266C52'"
                            onblur="this.style.borderColor='#D8C0AA'"
                        >
                    </div>

                    <div>
                        <label class="block font-semibold mb-2" style="color: #266C52;">Subjek</label>
                        <select class="input-field w-full px-6 py-4 border-2 rounded-xl focus:outline-none" style="border-color: #D8C0AA;" onfocus="this.style.borderColor='#266C52'" onblur="this.style.borderColor='#D8C0AA'">
                            <option>Informasi Wisata</option>
                            <option>Paket Tour</option>
                            <option>Pemesanan Hotel</option>
                            <option>Transportasi</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-2" style="color: #266C52;">Pesan</label>
                        <textarea 
                            class="input-field w-full px-6 py-4 border-2 rounded-xl focus:outline-none h-32"
                            style="border-color: #D8C0AA;"
                            placeholder="Tulis pesan Anda di sini..."
                            onfocus="this.style.borderColor='#266C52'"
                            onblur="this.style.borderColor='#D8C0AA'"
                        ></textarea>
                    </div>

                    <button 
                        type="submit" 
                        class="submit-button w-full text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2"
                        style="background-color: #266C52;"
                        onmouseover="this.style.backgroundColor='#1a5038'"
                        onmouseout="this.style.backgroundColor='#266C52'"
                    >
                        <span>Kirim Pesan</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-8">
            <div class="rounded-3xl p-10 text-white" style="background: linear-gradient(135deg, #266C52, #496A49);">
                <h2 class="text-3xl font-bold mb-6">Kantor Pusat Kami</h2>
                <div class="space-y-4 text-lg">
                    <div class="flex items-start gap-4">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <div>
                            <p class="font-semibold mb-1">Alamat Lengkap</p>
                            <p>Jl. Raya Ubud No. 88, Ubud, Gianyar, Bali 80571, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold mb-1">Akses</p>
                            <p>15 menit dari Monkey Forest, 30 menit dari Bandara Ngurah Rai</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        <div>
                            <p class="font-semibold mb-1">Parkir</p>
                            <p>Tersedia parkir gratis untuk mobil dan motor</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63080.79842698784!2d115.21842842167969!3d-8.506880999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd217e2e9e7a0d7%3A0x4030bfbca830200!2sUbud%2C%20Gianyar%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1635789012345!5m2!1sen!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>

<section class="py-20" style="background: linear-gradient(135deg, #C59F82, #D8C0AA);">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-8" style="color: #266C52;">Ikuti Kami di Social Media</h2>
        <div class="flex justify-center gap-6">
            <a href="#" class="social-icon w-16 h-16 bg-white rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" style="color: #266C52;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
            <a href="#" class="social-icon w-16 h-16 bg-white rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" style="color: #266C52;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
            </a>
            <a href="#" class="social-icon w-16 h-16 bg-white rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" style="color: #266C52;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
            </a>
            <a href="#" class="social-icon w-16 h-16 bg-white rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" style="color: #266C52;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
            </a>
            <a href="#" class="social-icon w-16 h-16 bg-white rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" style="color: #266C52;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<section class="container mx-auto px-6 py-20">
    <h2 class="text-4xl font-bold text-center mb-12" style="color: #266C52;">Pertanyaan yang Sering Diajukan</h2>
    <div class="max-w-3xl mx-auto space-y-4">
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 flex-shrink-0 mt-1" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <div>
                    <h3 class="text-xl font-bold mb-2" style="color: #266C52;">Kapan waktu terbaik berkunjung ke Bali?</h3>
                    <p style="color: #496A49;">
                        Waktu terbaik adalah April-Oktober (musim kemarau) dengan cuaca cerah dan minim hujan.
                        </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 flex-shrink-0 mt-1" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-xl font-bold mb-2" style="color: #266C52;">Berapa budget minimal untuk liburan ke Bali?</h3>
                    <p style="color: #496A49;">
                        Budget minimal sekitar Rp 3-5 juta per orang untuk 3-4 hari (sudah termasuk akomodasi, makan, dan transportasi).
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 flex-shrink-0 mt-1" style="color: #266C52;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <div>
                    <h3 class="text-xl font-bold mb-2" style="color: #266C52;">Apakah perlu menyewa kendaraan di Bali?</h3>
                    <p style="color: #496A49;">
                        Sangat disarankan menyewa motor atau mobil untuk mobilitas yang lebih fleksibel, atau gunakan jasa driver.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="container mx-auto px-6 py-20">
    <div class="rounded-3xl p-16 text-center text-white" style="background: linear-gradient(135deg, #266C52, #496A49);">
        <h2 class="text-4xl font-bold mb-4">Siap Menjelajahi Bali?</h2>
        <p class="text-xl mb-8">Kembali ke halaman utama untuk informasi lebih lengkap</p>
        <a href="/" class="inline-block px-8 py-4 rounded-xl font-bold transition-all hover:scale-105" style="background-color: #D8C0AA; color: #266C52;">
            Kembali ke Home
        </a>
    </div>
</section>
@endsection