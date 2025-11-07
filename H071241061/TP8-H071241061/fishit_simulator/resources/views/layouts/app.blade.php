<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fish It Simulator') - Roblox Fish Database</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00bcd4',
                        secondary: '#0288d1',
                        accent: '#00e5ff',
                        dark: '#001e3c',
                    },
                    boxShadow: {
                        glow: '0 0 25px rgba(0, 242, 255, 0.3)',
                        ocean: '0 0 20px rgba(0, 200, 255, 0.2)',
                    },
                    backdropBlur: {
                        xl: '20px',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #00111f 0%, #003554 50%, #005b82 100%);
            min-height: 100vh;
            color: white;
            background-attachment: fixed;
        }
        .card-hover {
            transition: all 0.4s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 255, 255, 0.25);
        }
        .gradient-text {
            background: linear-gradient(90deg, #00e5ff, #1e88e5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glass-nav {
            background: rgba(0, 35, 65, 0.6);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-footer {
            background: rgba(0, 35, 65, 0.7);
            backdrop-filter: blur(12px);
        }
        .btn-glass {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
        .btn-glass:hover {
            background: rgba(0, 242, 255, 0.2);
            border-color: rgba(0, 242, 255, 0.3);
            box-shadow: 0 0 10px rgba(0, 242, 255, 0.3);
        }

        select, option {
            background-color: rgba(0, 40, 70, 0.9) !important; 
            color: #dff9ff !important; 
        }
        select:hover {
            background-color: rgba(0, 70, 120, 0.9) !important;
        }
        option:hover, option:checked {
            background-color: rgba(0, 200, 255, 0.25) !important;
            color: #ffffff !important;
        }
    </style>
</head>
<body class="font-sans antialiased">

    <!-- Navbar -->
    <nav class="glass-nav sticky top-0 z-50 shadow-ocean">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('fishes.index') }}" class="flex items-center space-x-3 group">
                    <div class="p-2 rounded-lg bg-gradient-to-r from-cyan-400 to-blue-600 group-hover:scale-110 transition-transform shadow-glow">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2c-1.7 0-3.3.5-4.6 1.3L3 1v6h6L6.5 4.5C7.6 3.6 8.8 3 10 3c3.9 0 7 3.1 7 7s-3.1 7-7 7-7-3.1-7-7H1c0 5 4 9 9 9s9-4 9-9-4-9-9-9z"/>
                            <circle cx="10" cy="10" r="2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold gradient-text">Fish It Simulator</h1>
                        <p class="text-xs text-cyan-200 tracking-wider">🎮 Roblox Fish Database</p>
                    </div>
                </a>

                <!-- Menu -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('fishes.index') }}" 
                       class="btn-glass px-4 py-2 rounded-lg text-cyan-200 hover:text-white transition-all flex items-center space-x-2">
                        <span>📊</span>
                        <span>Fish Database</span>
                    </a>
                    <a href="{{ route('fishes.create') }}" 
                       class="px-4 py-2 rounded-lg bg-gradient-to-r from-cyan-400 to-blue-500 text-white hover:shadow-glow transition-all flex items-center space-x-2">
                        <span>➕</span>
                        <span>Add Fish</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-10">
        <!-- Alert Messages -->
        @if(session('success'))
        <div class="glass-card border-l-4 border-green-400 text-green-100 p-4 rounded-xl shadow-glow mb-6" role="alert">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="glass-card border-l-4 border-red-400 text-red-200 p-4 rounded-xl shadow-glow mb-6" role="alert">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="font-semibold">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="glass-footer text-white py-6 mt-16 border-t border-white/10">
        <div class="container mx-auto px-6 text-center">
            <p class="text-sm text-cyan-200 italic">🎣 "Teruslah Memancing Karena Waktu Adalah Ikan" 🎣</p>
            <p class="text-xs text-cyan-400 mt-2">© 2025 Fish It Simulator</p>
        </div>
    </footer>

    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.style.transition = 'opacity 0.6s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 600);
            });
        }, 5000);
    </script>
</body>
</html>
