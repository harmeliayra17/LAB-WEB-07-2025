<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eksplor Tashkent')</title>
    
    <style>
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f4f4f4; 
            
            
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
            
        }
        
        header { 
            background: #0072C6; 
            color: white; 
            padding: 1rem 2rem; 
        }
        
        header h1 { 
            margin: 0; 
        }
        
        nav { 
            background: #005A9E; 
        }
        
        nav ul { 
            list-style: none; 
            margin: 0; 
            padding: 0; 
            display: flex; 
        }
        
        nav ul li a { 
            display: block; 
            padding: 1rem; 
            color: white; 
            text-decoration: none; 
        }
        
        nav ul li a:hover { 
            background: #004071; 
        }
        
        
        main.container { 
            max-width: 1000px; 
            margin: 2rem auto; 
            padding: 1rem; 
            background: white; 
            flex-grow: 1; 
            
        }
        
        footer { 
            text-align: center; 
            padding: 1rem; 
            background: #333; 
            color: white; 
            
            
        }

        .card-container { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 1rem; 
            justify-content: center; 
        }
        
        .card { 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            width: 300px; 
        }
        
        .card img { 
            width: 100%; 
            height: 200px; 
            object-fit: cover; 
        }
        
        .card-content { 
            padding: 1rem; 
        }
        
        .card-content h3 { 
            margin-top: 0; 
        }
    </style>
</head>
<body>

    <header>
        <h1>Eksplor Pariwisata Tashkent</h1>
    </header>
    
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/destinasi">Destinasi</a></li>
            <li><a href="/kuliner">Kuliner</a></li>
            <li><a href="/galeri">Galeri</a></li>
            <li><a href="/kontak">Kontak</a></li>
        </ul>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 Eksplor Tashkent. All Rights Reserved.</p>
    </footer>

</body>
</html>