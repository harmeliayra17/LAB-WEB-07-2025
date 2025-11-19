<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockTransferController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('categories', CategoryController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('products', ProductController::class);

Route::get('stocks', [StockController::class, 'index'])
    ->name('stocks.index');

Route::get('stocks/transfer', [StockTransferController::class, 'create'])
    ->name('stocks.transfer.create');

Route::post('stocks/transfer', [StockTransferController::class, 'store'])
    ->name('stocks.transfer.store');
