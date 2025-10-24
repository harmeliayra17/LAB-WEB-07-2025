<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Jogja</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1 0 auto;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen font-sans bg-gray-100">
    <header class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Eksplor Jogja</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                    <li><a href="{{ route('destinasi') }}" class="hover:underline">Destinasi</a></li>
                    <li><a href="{{ route('kuliner') }}" class="hover:underline">Kuliner</a></li>
                    <li><a href="{{ route('galeri') }}" class="hover:underline">Galeri</a></li>
                    <li><a href="{{ route('kontak') }}" class="hover:underline">Kontak</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8 grow">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; 2025 Asal Gua Tuh - Jogja. Bruakaka.</p>
    </footer>
</body>
</html>