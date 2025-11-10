<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProductWarehouseController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('product-details', ProductDetailController::class);
Route::resource('product-warehouse', ProductWarehouseController::class);
Route::post('/product-warehouse', [ProductWarehouseController::class, 'store'])->name('product-warehouse.store');
