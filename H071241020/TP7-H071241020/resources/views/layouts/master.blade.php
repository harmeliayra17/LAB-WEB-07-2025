<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Eksplor Polewali Mandar</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background:#f4f7fa;
            color:#333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background:linear-gradient(135deg, #1e40af, #3b82f6);
            color:white;
            padding:1.5rem;
            text-align:center;
            box-shadow:0 4px 15px rgba(0,0,0,0.1);
        }
        header h1 { font-size:2rem; margin:0.5rem 0; }
        nav a {
            color:white; text-decoration:none; margin:0 15px; font-weight:500;
            padding:8px 16px; border-radius:25px; transition:0.3s;
        }
        nav a:hover { background:rgba(255,255,255,0.2); }

        /* KONTEN UTAMA: MINIMAL TINGGI LAYAR */
        .container {
            flex: 1;
            max-width:1200px;
            margin:2rem auto;
            padding:0 1rem;
            min-height: calc(100vh - 200px); /* Pastikan cukup tinggi */
        }

        .cards {
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(320px,1fr));
            gap:2rem;
            margin:2rem 0;
        }
        .card {
            background:white;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,0.12);
            transition:0.3s;
        }
        .card:hover { transform:translateY(-10px); }
        .card img {
            width:100%;
            height:280px; /* GAMBAR LEBIH BESAR */
            object-fit:cover;
        }
        .card-body { padding:1.5rem; }
        .card h3 { margin:0.5rem 0; color:#1e40af; font-size:1.3rem; }

        .gallery {
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(280px,1fr));
            gap:1.5rem;
            margin:2rem 0;
        }
        .gallery img {
            width:100%;
            height:320px; /* GAMBAR GALERI LEBIH BESAR */
            object-fit:cover;
            border-radius:16px;
            box-shadow:0 8px 25px rgba(0,0,0,0.15);
            transition:0.3s;
        }
        .gallery img:hover { transform:scale(1.03); }

        form {
            max-width:600px; margin:2rem auto; background:white;
            padding:2.5rem; border-radius:18px;
            box-shadow:0 12px 35px rgba(0,0,0,0.12);
        }
        input, textarea {
            width:100%; padding:14px; margin:10px 0;
            border:2px solid #e5e7eb; border-radius:10px;
        }
        button {
            background:#3b82f6; color:white; border:none;
            padding:14px 32px; border-radius:30px;
            cursor:pointer; font-weight:600; font-size:1.1rem;
        }

        /* FOOTER: SELALU DI BAWAH */
        footer {
            background:#1f2937;
            color:white;
            text-align:center;
            padding:1.8rem;
            margin-top:auto; /* Dorong ke bawah */
            width:100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Eksplor Pariwisata Polewali Mandar</h1>
        <nav>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('destinasi') }}">Destinasi</a>
            <a href="{{ route('kuliner') }}">Kuliner</a>
            <a href="{{ route('galeri') }}">Galeri</a>
            <a href="{{ route('kontak') }}">Kontak</a>
        </nav>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <p>© 2025 TP7-H071241020 - Eksplor Pariwisata Nusantara</p>
    </footer>
</body>
</html>
