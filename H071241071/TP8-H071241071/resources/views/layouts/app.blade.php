<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish It Simulator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <a class="flex-shrink-0 flex items-center text-xl font-bold text-blue-600" href="{{ route('fishes.index') }}">
                        Fish It Management
                    </a>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('fishes.create') }}" class="inline-flex items-center justify-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
                        + Tambah Ikan
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                @yield('content')
            </div>
        </div>
    </main>
</body>
</html>