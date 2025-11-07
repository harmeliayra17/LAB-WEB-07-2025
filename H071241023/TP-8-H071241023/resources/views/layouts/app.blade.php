<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fish It!')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#8b5cf6',  
                        accent: '#a78bfa', 
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-cover bg-center relative text-gray-900"
    style="background-image: url('{{ asset('images/background.png') }}');">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    <nav class="relative z-10 bg-violet-500/30 backdrop-blur-lg border-b border-white/30 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">

            <h1 class="text-lg font-semibold text-white drop-shadow flex items-center gap-2">
                <span class="tracking-wide">Fish It!</span>
            </h1>

            <div class="flex items-center gap-6">
                <a href="{{ route('fishes.index') }}"
                    class="relative text-white font-medium hover:text-violet-200 transition duration-300
                        after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-violet-300
                        hover:after:w-full after:transition-all after:duration-300
                        {{ request()->routeIs('fishes.index') ? 'after:w-full text-violet-100' : '' }}">
                    Home
                </a>
            </div>
        </div>
    </nav>

    <main class="relative z-10">
        @yield('content')
    </main>

</body>
</html>