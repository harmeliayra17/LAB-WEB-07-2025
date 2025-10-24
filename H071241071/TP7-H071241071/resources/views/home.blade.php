@extends('layouts.master')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold mb-4 text-center">Selamat Datang di Jogja</h2>
        <p class="text-lg mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <img src="{{ asset('images/jogja-overview.jpg') }}" alt="Pemandangan Jogja" class="w-full max-w-xl h-auto object-contain rounded-lg mb-4 mx-auto">
        <p class="text-center">Mampir rumahku euy kalo ke Jogja</p>
    </div>
@endsection