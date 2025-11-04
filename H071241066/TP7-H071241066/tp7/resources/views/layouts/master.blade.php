<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beauty of Bali')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: #264D52;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="gradient-bg shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <h1 class="text-white text-2xl font-bold">Beauty of Bali</h1>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="/" class="nav-link text-white font-medium">Home</a>
                    <a href="/destinasi" class="nav-link text-white font-medium">Destinasi</a>
                    <a href="/kuliner" class="nav-link text-white font-medium">Kuliner</a>
                    <a href="/galeri" class="nav-link text-white font-medium">Galeri</a>
                    <a href="/kontak" class="nav-link text-white font-medium">Kontak</a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="gradient-bg text-white py-8 mt-20">
        <div class="container mx-auto px-6 text-center">
            <p class="text-lg">&copy; 2025 Beauty of Bali - Discover the Island of Gods</p>
        </div>
    </footer>
</body>
</html>