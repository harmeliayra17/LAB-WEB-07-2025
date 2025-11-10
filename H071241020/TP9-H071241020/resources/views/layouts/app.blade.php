<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Manajemen Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .nav-link.active {
            color: #93c5fd; /* Warna biru muda untuk tautan aktif */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center flex-wrap">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold transition duration-300 hover:text-blue-200">Manajemen Produk</a>
            <div class="space-x-4 mt-2 md:mt-0">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} nav-link hover:text-blue-200 transition duration-300">Dashboard</a>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.index') ? 'active' : '' }} nav-link hover:text-blue-200 transition duration-300">Kategori</a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'active' : '' }} nav-link hover:text-blue-200 transition duration-300">Produk</a>
                <a href="{{ route('warehouses.index') }}" class="{{ request()->routeIs('warehouses.index') ? 'active' : '' }} nav-link hover:text-blue-200 transition duration-300">Gudang</a>
                <a href="{{ route('product-details.index') }}" class="{{ request()->routeIs('product-details.index') ? 'active' : '' }} nav-link hover:text-blue-200 transition duration-300">Detail Produk</a>
                <a href="{{ route('product-warehouse.index') }}" class="{{ request()->routeIs('product-warehouse.index') ? 'active' : '' }} nav-link hover:text-blue-200 transition duration-300">Stok Gudang</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto mt-6">
        @yield('content')
    </div>
</body>
</html>
