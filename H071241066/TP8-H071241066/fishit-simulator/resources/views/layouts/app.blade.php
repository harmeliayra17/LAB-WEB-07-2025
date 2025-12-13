<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fish It Simulator')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('/images/background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: #333;
        }

        .navbar {
            background: rgba(26, 35, 126, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.2rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .navbar-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
            font-size: 1.8rem;
        }

        .navbar-menu a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }

        .navbar-menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .card-header {
            border-bottom: 3px solid #1a237e;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.8rem;
            color: #1a237e;
            font-weight: bold;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-weight: 500;
        }

        .btn-primary {
            background: #1a237e;
            color: white;
        }

        .btn-primary:hover {
            background: #0d47a1;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 35, 126, 0.4);
        }

        .btn-success {
            background: #2e7d32;
            color: white;
        }

        .btn-success:hover {
            background: #1b5e20;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #f57c00;
            color: white;
        }

        .btn-warning:hover {
            background: #e65100;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #c62828;
            color: white;
        }

        .btn-danger:hover {
            background: #b71c1c;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #455a64;
            color: white;
        }

        .btn-secondary:hover {
            background: #37474f;
            transform: translateY(-2px);
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }

        .alert-success {
            background: #e8f5e9;
            border-color: #2e7d32;
            color: #1b5e20;
        }

        .alert-danger {
            background: #ffebee;
            border-color: #c62828;
            color: #b71c1c;
        }

        .alert-info {
            background: #e3f2fd;
            border-color: #1976d2;
            color: #0d47a1;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <h1 class = "navbar-brand">Fish It Simulator</h1>
            <ul class="navbar-menu">
                <li><a href="{{ route('fishes.create') }}">+ Tambah Ikan</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>