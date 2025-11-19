<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Manajemen Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-purple-900 text-gray-100 font-sans">
    <nav class="backdrop-blur-md bg-purple-700/30 border-b border-purple-500/20 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14">
                <div>
                    <h1 class="text-lg font-semibold text-purple-200 tracking-wide">
                        Manajemen Produk
                    </h1>
                </div>
                <div class="hidden md:flex items-center space-x-4 text-sm">
                    <a href="{{ route('home') }}"
                        class="px-3 py-2 rounded-md transition
                        {{ request()->routeIs('home') 
                            ? 'bg-purple-500/60 text-white font-semibold shadow-md' 
                            : 'hover:bg-purple-500/30' }}">
                        Home
                    </a>
                    <a href="{{ route('categories.index') }}"
                        class="px-3 py-2 rounded-md transition
                        {{ request()->routeIs('categories.*') 
                            ? 'bg-purple-500/60 text-white font-semibold shadow-md' 
                            : 'hover:bg-purple-500/30' }}">
                        Category
                    </a>
                    <a href="{{ route('warehouses.index') }}"
                        class="px-3 py-2 rounded-md transition
                        {{ request()->routeIs('warehouses.*') 
                            ? 'bg-purple-500/60 text-white font-semibold shadow-md' 
                            : 'hover:bg-purple-500/30' }}">
                        Warehouse
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="px-3 py-2 rounded-md transition
                        {{ request()->routeIs('products.*') 
                            ? 'bg-purple-500/60 text-white font-semibold shadow-md' 
                            : 'hover:bg-purple-500/30' }}">
                        Product
                    </a>
                    <a href="{{ route('stocks.index') }}"
                        class="px-3 py-2 rounded-md transition
                        {{ request()->routeIs('stocks.index') 
                            ? 'bg-purple-500/60 text-white font-semibold shadow-md' 
                            : 'hover:bg-purple-500/30' }}">
                        Stock
                    </a>
                    <a href="{{ route('stocks.transfer.create') }}"
                        class="px-3 py-2 rounded-md transition
                        {{ request()->routeIs('stocks.transfer.*') 
                            ? 'bg-purple-500/60 text-white font-semibold shadow-md' 
                            : 'hover:bg-purple-500/30' }}">
                        Transfer
                    </a>
                </div>
                <button id="nav-toggle"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-md
                            text-purple-100 hover:bg-purple-500/40 focus:outline-none">
                    <i id="nav-toggle-icon" class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </nav>

    <div id="nav-backdrop"
            class="hidden md:hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm">
        <div id="nav-drawer"
                class="absolute right-0 top-0 h-full w-3/4 max-w-xs
                    bg-purple-900/80 border-l border-purple-300/40
                    shadow-2xl p-4 transform translate-x-full
                    transition-transform duration-300 ease-out">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-purple-100 tracking-wide">
                    Menu
                </h2>
                <button id="nav-close"
                        class="inline-flex items-center justify-center p-1.5 rounded-full
                            text-purple-100 hover:bg-purple-500/40 focus:outline-none">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>
            <div class="flex flex-col space-y-1 text-sm">
                <a href="{{ route('home') }}"
                    class="px-3 py-2 rounded-md transition block
                    {{ request()->routeIs('home') 
                        ? 'bg-purple-500/80 text-white font-semibold shadow-md' 
                        : 'hover:bg-purple-500/40' }}">
                    Home
                </a>
                <a href="{{ route('categories.index') }}"
                    class="px-3 py-2 rounded-md transition block
                    {{ request()->routeIs('categories.*') 
                        ? 'bg-purple-500/80 text-white font-semibold shadow-md' 
                        : 'hover:bg-purple-500/40' }}">
                    Category
                </a>
                <a href="{{ route('warehouses.index') }}"
                    class="px-3 py-2 rounded-md transition block
                    {{ request()->routeIs('warehouses.*') 
                        ? 'bg-purple-500/80 text-white font-semibold shadow-md' 
                        : 'hover:bg-purple-500/40' }}">
                    Warehouse
                </a>
                <a href="{{ route('products.index') }}"
                    class="px-3 py-2 rounded-md transition block
                    {{ request()->routeIs('products.*') 
                        ? 'bg-purple-500/80 text-white font-semibold shadow-md' 
                        : 'hover:bg-purple-500/40' }}">
                    Product
                </a>
                <a href="{{ route('stocks.index') }}"
                    class="px-3 py-2 rounded-md transition block
                    {{ request()->routeIs('stocks.index') 
                        ? 'bg-purple-500/80 text-white font-semibold shadow-md' 
                        : 'hover:bg-purple-500/40' }}">
                    Stock
                </a>
                <a href="{{ route('stocks.transfer.create') }}"
                    class="px-3 py-2 rounded-md transition block
                    {{ request()->routeIs('stocks.transfer.*') 
                        ? 'bg-purple-500/80 text-white font-semibold shadow-md' 
                        : 'hover:bg-purple-500/40' }}">
                    Transfer
                </a>
            </div>
        </div>
    </div>
    <div class="max-w-6xl mx-auto mt-4 px-4">
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-400/40 text-green-200 px-4 py-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-400/40 text-red-200 px-4 py-2 rounded mb-3">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <main class="max-w-6xl mx-auto px-4 py-6 bg-white/5 backdrop-blur-sm rounded-lg mt-4 shadow-lg border border-white/10">
        @yield('content')
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle   = document.getElementById('nav-toggle');
            const icon     = document.getElementById('nav-toggle-icon');
            const backdrop = document.getElementById('nav-backdrop');
            const drawer   = document.getElementById('nav-drawer');
            const closeBtn = document.getElementById('nav-close');

            function openMenu() {
                if (!backdrop || !drawer) return;
                backdrop.classList.remove('hidden');
                drawer.classList.remove('translate-x-full');
                drawer.classList.add('translate-x-0');
                if (icon) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                }
            }

            function closeMenu() {
                if (!backdrop || !drawer) return;
                drawer.classList.remove('translate-x-0');
                drawer.classList.add('translate-x-full');
                if (icon) {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
                setTimeout(() => {
                    backdrop.classList.add('hidden');
                }, 300);
            }

            if (toggle) {
                toggle.addEventListener('click', () => {
                    if (backdrop.classList.contains('hidden')) {
                        openMenu();
                    } else {
                        closeMenu();
                    }
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeMenu);
            }

            if (backdrop) {
                backdrop.addEventListener('click', (e) => {
                    if (e.target === backdrop) {
                        closeMenu();
                    }
                });
            }

            if (drawer) {
                const links = drawer.querySelectorAll('a');
                links.forEach(link => {
                    link.addEventListener('click', () => {
                        closeMenu();
                    });
                });
            }
        });
    </script>
</body>
</html>