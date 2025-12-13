<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Produk')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #fff5f8; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb {
            background-color: #f8b3c3;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: #f58fb1;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-pink-200/80 backdrop-blur-md shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-heart text-3xl text-pink-500"></i>
                    <span class="text-2xl font-semibold text-pink-700 tracking-wide">ProductHub</span>
                </div>

                <!-- Desktop menu -->
                <div class="hidden sm:flex space-x-5">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fas fa-cube mr-1"></i> Produk
                    </a>
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags mr-1"></i> Kategori
                    </a>
                    <a href="{{ route('warehouses.index') }}" class="nav-link {{ request()->routeIs('warehouses.*') ? 'active' : '' }}">
                        <i class="fas fa-warehouse mr-1"></i> Gudang
                    </a>
                    <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.*') ? 'active' : '' }}">
                        <i class="fas fa-boxes mr-1"></i> Stok
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 animate-fade-in">
        <div class="bg-pink-50 border-l-4 border-pink-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-pink-500 text-lg"></i>
                <p class="ml-3 text-pink-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 animate-fade-in">
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                <p class="ml-3 text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-lg p-6 sm:p-10 border border-pink-100">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-pink-100 shadow-inner mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-pink-600 text-sm font-medium">
                 © 2025 ProductHub 
            </p>
        </div>
    </footer>

    <!-- Custom Styles -->
    <style>
        .nav-link {
            @apply px-4 py-2 rounded-lg text-sm font-medium text-pink-700 hover:text-white hover:bg-pink-400 transition-all duration-200;
        }
        .nav-link.active {
            @apply bg-pink-500 text-white shadow-sm;
        }

        /* Animasi halus */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        /* Mobile nav */
        @media (max-width: 640px) {
            nav div.hidden {
                display: none;
            }
        }
    </style>
</body>
</html>
