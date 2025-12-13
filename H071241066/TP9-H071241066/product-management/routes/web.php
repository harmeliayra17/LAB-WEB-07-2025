<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DashboardController; 

// Halaman utama (root URL /) diarahkan ke DashboardController::index()
Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); 

// 1. Manajemen Category Produk
Route::resource('categories', CategoryController::class);

// 2. Manajemen Warehouse 
Route::resource('warehouses', WarehouseController::class);

// 3. Manajemen Produk
Route::resource('products', ProductController::class);

// 4. Manajemen Stok 
Route::get('stocks', [StockController::class, 'index'])->name('stocks.index'); 
Route::post('stocks/transfer', [StockController::class, 'transfer'])->name('stocks.transfer'); 

// 5. Riwayat Stok 
Route::get('stocks/history', [StockController::class, 'history'])->name('stocks.history');