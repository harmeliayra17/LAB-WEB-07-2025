<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/destinasi', [PageController::class, 'destinasi'])->name('destinasi');

Route::get('/kuliner', [PageController::class, 'kuliner'])->name('kuliner');

Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');

Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
