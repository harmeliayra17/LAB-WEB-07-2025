@extends('layouts.master')

@section('title', 'Kontak - Eksplor Balikpapan')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">📞 Hubungi Kami</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Ada pertanyaan tentang Balikpapan? Kami siap membantu Anda!</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">✉️ Kirim Pesan</h3>
            <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Masukkan nama Anda">
                    </div>

                    <div>
                        <label for="telepon" class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                        <input type="tel" id="telepon" name="telepon" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="contoh@email.com">
                </div>

                <div>
                    <label for="subjek" class="block text-gray-700 font-semibold mb-2">Subjek</label>
                    <select id="subjek" name="subjek" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        <option value="">Pilih Subjek Pesan</option>
                        <option value="info-wisata">🗺️ Informasi Wisata</option>
                        <option value="booking">🏨 Booking & Reservasi</option>
                        <option value="kerjasama">🤝 Kerjasama</option>
                        <option value="kritik-saran">💡 Kritik & Saran</option>
                        <option value="lainnya">📋 Lainnya</option>
                    </select>
                </div>

                <div>
                    <label for="pesan" class="block text-gray-700 font-semibold mb-2">Pesan</label>
                    <textarea id="pesan" name="pesan" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Tulis pesan Anda di sini..."></textarea>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                    📤 Kirim Pesan
                </button>
            </form>
        </div>

        <!-- Contact Information -->
        <div class="space-y-6">
            <!-- Info Cards -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">📍 Informasi Kontak</h3>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition duration-300">
                        <div class="bg-blue-500 p-3 rounded-lg">
                            <span class="text-white text-lg">🏢</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Alamat Kantor</h4>
                            <p class="text-gray-600">Jl. Jenderal Sudirman No. 1<br>Balikpapan, Kalimantan Timur 76114</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition duration-300">
                        <div class="bg-green-500 p-3 rounded-lg">
                            <span class="text-white text-lg">📞</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Telepon & WhatsApp</h4>
                            <p class="text-gray-600">(0542) 123-4567<br>+62 812-3456-7890</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-red-50 rounded-xl hover:bg-red-100 transition duration-300">
                        <div class="bg-red-500 p-3 rounded-lg">
                            <span class="text-white text-lg">📧</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Email</h4>
                            <p class="text-gray-600">info@eksplorbalikpapan.com<br>wisata@balikpapan.go.id</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition duration-300">
                        <div class="bg-purple-500 p-3 rounded-lg">
                            <span class="text-white text-lg">🕒</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Jam Operasional</h4>
                            <p class="text-gray-600">Senin - Jumat: 08:00 - 17:00 WITA<br>Sabtu: 08:00 - 14:00 WITA<br>Minggu & Libur: Tutup</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-lg p-8 text-white">
                <h3 class="text-2xl font-bold mb-4">🌐 Follow Kami</h3>
                <p class="mb-6 text-blue-100">Ikuti media sosial untuk update terbaru seputar wisata Balikpapan!</p>
                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm p-3 rounded-xl text-center transition duration-300">
                        <div class="text-lg mb-1">📘</div>
                        <span class="text-sm font-semibold">Facebook</span>
                    </a>
                    <a href="#" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm p-3 rounded-xl text-center transition duration-300">
                        <div class="text-lg mb-1">📷</div>
                        <span class="text-sm font-semibold">Instagram</span>
                    </a>
                    <a href="#" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm p-3 rounded-xl text-center transition duration-300">
                        <div class="text-lg mb-1">🐦</div>
                        <span class="text-sm font-semibold">Twitter</span>
                    </a>
                    <a href="#" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm p-3 rounded-xl text-center transition duration-300">
                        <div class="text-lg mb-1">▶️</div>
                        <span class="text-sm font-semibold">YouTube</span>
                    </a>
                </div>
            </div>

            <!-- Map Placeholder -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">🗺️ Lokasi Kami</h3>
                <div class="bg-gradient-to-br from-blue-100 to-green-100 rounded-xl h-64 flex items-center justify-center border-2 border-dashed border-blue-300">
                    <div class="text-center text-blue-700">
                        <div class="text-4xl mb-3">📍</div>
                        <p class="font-bold text-lg">Peta Lokasi Balikpapan</p>
                        <p class="text-sm">Kalimantan Timur, Indonesia</p>
                        <button class="mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition duration-300">
                            Buka di Google Maps
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl shadow-lg p-8 border border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">❓ Pertanyaan yang Sering Diajukan</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-3">🚗 Bagaimana cara menuju Balikpapan?</h4>
                <p class="text-gray-600 text-sm">Balikpapan dapat diakses melalui Bandara Internasional Sultan Aji Muhammad Sulaiman Sepinggan dengan penerbangan dari berbagai kota besar di Indonesia.</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-3">🌤️ Kapan waktu terbaik mengunjungi?</h4>
                <p class="text-gray-600 text-sm">April hingga Oktober adalah periode dengan curah hujan lebih rendah, cocok untuk aktivitas outdoor dan eksplorasi wisata alam.</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-3">👨‍💼 Apakah tersedia pemandu wisata?</h4>
                <p class="text-gray-600 text-sm">Ya, tersedia layanan pemandu wisata profesional yang dapat membantu Anda menjelajahi Balikpapan. Hubungi kami untuk informasi.</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-3">💰 Berapa budget yang diperlukan?</h4>
                <p class="text-gray-600 text-sm">Backpacker: Rp 300-500K/hari, Mid-range: Rp 700K-1.5Jt/hari, Luxury: di atas Rp 2Jt/hari (termasuk akomodasi & transportasi).</p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl p-8">
        <h3 class="text-2xl font-bold mb-4">Siap Menjelajahi Balikpapan?</h3>
        <p class="text-blue-100 mb-6">Mulai petualangan Anda di kota minyak yang penuh pesona</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('destinasi') }}" class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition duration-300">
                🗺️ Lihat Destinasi
            </a>
            <a href="{{ route('kuliner') }}" class="bg-blue-400 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-300 transition duration-300">
                🍜 Coba Kuliner
            </a>
            <a href="{{ route('galeri') }}" class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition duration-300">
                📸 Jelajahi Galeri
            </a>
        </div>
    </div>
</div>
@endsection