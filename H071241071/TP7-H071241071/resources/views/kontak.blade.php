@extends('layouts.master')

@section('content')
    <h2 class="text-3xl font-bold mb-6 text-center">Kontak Kami</h2>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
        <p class="mb-4"><strong>Alamat:</strong> Jl. Malioboro No. 123, Yogyakarta</p>
        <p class="mb-4"><strong>Email:</strong> info@eksplorjogja.com</p>
        <p class="mb-4"><strong>Telepon:</strong> (0274) 123-4567</p>
        <h3 class="text-xl font-semibold mb-4">Kirim Pesan</h3>
        <form>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Nama</label>
                <input type="text" id="name" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium">Pesan</label>
                <textarea id="message" class="w-full p-2 border rounded" rows="4"></textarea>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Kirim</button>
        </form>
    </div>
@endsection