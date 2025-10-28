<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website pariwisata Balikpapan - destinasi, kuliner, dan galeri kota minyak Kalimantan Timur">
    <title>@yield('title', 'Eksplor Balikpapan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Eksplor Balikpapan</h1>
                    <p class="text-blue-100 text-sm">Kota Minyak di Pesisir Kalimantan Timur</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-4">
                <ul class="flex flex-wrap gap-2 justify-center md:justify-start">
                    <li>
                        <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                            🏠 Home
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('destinasi') }}" :active="request()->routeIs('destinasi')">
                            🗺️ Destinasi
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('kuliner') }}" :active="request()->routeIs('kuliner')">
                            🍛 Kuliner
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('galeri') }}" :active="request()->routeIs('galeri')">
                            🖼️ Galeri
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('kontak') }}" :active="request()->routeIs('kontak')">
                            📞 Kontak
                        </x-nav-link>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Eksplor Balikpapan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>