@extends('layouts.master')
@section('title', 'Kontak')

@section('content')
<h2 style="text-align:center; margin:2rem 0; color:#1e40af;">Hubungi Kami</h2>
<form>
    <label>Nama:</label>
    <input type="text" placeholder="Masukkan nama Anda">

    <label>Email:</label>
    <input type="email" placeholder="email@contoh.com">

    <label>Pesan:</label>
    <textarea rows="5" placeholder="Tulis pesan Anda..."></textarea>

    <button type="submit">Kirim Pesan</button>
</form>

<div style="text-align:center; margin-top:2rem; color:#555;">
    <p><strong>Dinas Kebudayaan & Pariwisata Polman</strong></p>
    <p>Jl. Jend. Sudirman, Polewali | Telp: (0436) 21901</p>
    <p>Email: disbudpar@polmankab.go.id</p>
</div>
@endsection
