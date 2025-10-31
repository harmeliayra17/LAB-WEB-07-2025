@extends('layouts.master')

@section('title', 'Kontak Kami')

@section('content')
    <h2>Hubungi Kami</h2>
    <p>Jika Anda memiliki pertanyaan, silakan hubungi kami melalui form di bawah ini.</p>

    <form action="#" method="POST" style="display: grid; gap: 10px; max-width: 500px;">
        <div>
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label for="pesan">Pesan:</label><br>
            <textarea id="pesan" name="pesan" rows="5" style="width: 100%; padding: 8px;"></textarea>
        </div>
        <div>
            <button type="submit" style="padding: 10px 20px; background: #0072C6; color: white; border: none; cursor: pointer;">Kirim</button>
        </div>
    </form>
@endsection