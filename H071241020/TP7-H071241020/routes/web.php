<?php
// routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('home'))->name('home');
Route::get('/destinasi', fn() => view('destinasi'))->name('destinasi');
Route::get('/kuliner', fn() => view('kuliner'))->name('kuliner');
Route::get('/galeri', fn() => view('galeri'))->name('galeri');
Route::get('/kontak', fn() => view('kontak'))->name('kontak');
