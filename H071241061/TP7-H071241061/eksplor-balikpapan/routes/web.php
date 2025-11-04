<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Halaman Home
Route::get('/', function () {
    return view('home');
})->name('home'); 

// Halaman Destinasi
Route::get('/destinasi', function () {
    return view('destinasi');
})->name('destinasi');

// Halaman Kuliner
Route::get('/kuliner', function () {
    return view('kuliner');
})->name('kuliner');

// Halaman Galeri
Route::get('/galeri', function () {
    return view('galeri');
})->name('galeri');

// Halaman Kontak
Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');