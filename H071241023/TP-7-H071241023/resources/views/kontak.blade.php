@extends('layouts.master')

@section('content')

<section class="title text-center mt-8 mb-6">
  <h2 class="text-3xl font-bold mb-2">Kontak</h2>
  <p class="text-gray-600">Hubungi kami untuk informasi lebih lanjut atau pertanyaan seputar Bandung.</p>
</section>

<section class="contact-form max-w-2xl mx-auto px-6 mb-16">
  <form method="POST" action="#" onsubmit="event.preventDefault(); alert('Pesan terkirim!'); setTimeout(() => location.reload(), 500);" class="space-y-5">
    @csrf

    <div class="form-group">
      <label for="nama" class="block mb-1 font-medium text-gray-700">Nama</label>
      <input id="nama" name="nama" type="text"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
            placeholder="Masukkan nama Anda" required>
    </div>

    <div class="form-group">
      <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
      <input id="email" name="email" type="email"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
            placeholder="Masukkan alamat email" required>
    </div>

    <div class="form-group">
      <label for="pesan" class="block mb-1 font-medium text-gray-700">Pesan</label>
      <textarea id="pesan" name="pesan" rows="4"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
                placeholder="Tulis pesan Anda di sini..." required></textarea>
    </div>

    <div class="text-center">
      <button type="submit"
              class="bg-orange-500 text-white px-5 py-2 rounded-md hover:bg-orange-700 transition">
        Kirim
      </button>
    </div>
  </form>
</section>
@endsection