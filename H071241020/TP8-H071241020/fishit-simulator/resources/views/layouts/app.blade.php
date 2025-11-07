<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish It Roblox - {{ $title ?? 'Dashboard' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f0fa; /* Warna biru muda untuk tema laut */
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #1e40af; /* Biru tua untuk navbar */
            color: white;
        }
        .navbar a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .content {
            padding: 20px;
            min-height: 80vh;
        }
    </style>
</head>
<body>
    <nav class="navbar p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Tombol Akses (Kiri) -->
            <div>
                <a href="{{ route('fishes.index') }}" class="mr-4">Daftar Ikan</a>
                <a href="{{ route('fishes.create') }}">Tambah Ikan</a>
            </div>

            <!-- Nama Aplikasi (Kanan) -->
            <div class="text-2xl font-bold">
                Fish It Roblox
            </div>
        </div>
    </nav>

    <div class="content container mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
