<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FishController;

// Rute untuk root URL mengarah ke index fishes
Route::get('/', function () {
    return redirect()->route('fishes.index');
});

// Resource route untuk fishes
Route::resource('fishes', FishController::class);
