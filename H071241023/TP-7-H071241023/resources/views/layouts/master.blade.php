<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eksplorasi Kota Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<body>
    <nav class="w-full bg-stone-950 text-white z-50">
        <ul class="flex justify-between gap-8 py-4">
            <li><a href="{{ route('home')}}" class="hover:text-orange-500 ml-10">Home</a></li>
            <li><a href="{{ route('destinasi')}}" class="hover:text-orange-500">Destinasi</a></li>
            <li><a href="{{ route('kuliner')}}" class="hover:text-orange-500">Kuliner</a></li>
            <li><a href="{{ route('galeri')}}" class="hover:text-orange-500">Galeri</a></li>
            <li><a href="{{ route('kontak')}}" class="hover:text-orange-500 mr-10">Kontak</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="w-full bg-stone-950 text-slate-100 text-center">
        <div class="px-12 py-10">
            <h3 class="text-lg font-semibold mb-1">EKSPLORASI KOTA BANDUNG</h3>
            <p class="text-sm mb-4 text-slate-400">"Tuhan menciptakan Bandung saat tersenyum"</p>
            <ul class="flex justify-center gap-6 text-2xl">
            <li>
                <a href="https://facebook.com" target="_blank" class="hover:text-orange-500 transition">
                <i class="fa-brands fa-facebook-f"></i>
                </a>
            </li>
            <li>
                <a href="https://instagram.com" target="_blank" class="hover:text-orange-500 transition">
                <i class="fa-brands fa-instagram"></i>
                </a>
            </li>
            <li>
                <a href="https://x.com" target="_blank" class="hover:text-orange-400 transition">
                <i class="fa-brands fa-x-twitter"></i>
                </a>
            </li>
            <li>
                <a href="https://youtube.com" target="_blank" class="hover:text-orange-500 transition">
                <i class="fa-brands fa-youtube"></i>
                </a>
            </li>
            <li>
                <a href="https://tiktok.com" target="_blank" class="hover:text-orange-300 transition">
                <i class="fa-brands fa-tiktok"></i>
                </a>
            </li>
            </ul>
        </div>
        <div class="relative border-t border-orange-500">
            <a href="#"
                class="absolute left-1/2 -translate-x-1/2 -translate-y-1/2 bg-orange-500 hover:bg-orange-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>
            </a>

            <p class="text-center text-xs text-slate-400 mt-8 pb-4">
                &copy; 2024 Eksplorasi Kota Bandung. All rights reserved.
            </p>
        </div>
    </footer>
    @stack('scripts')
    <script src="{{ asset('js/slider.js') }}"></script>
</body>
</html>
