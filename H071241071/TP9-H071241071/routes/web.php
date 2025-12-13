<?php

use App\Http\Controllers\{
    CategoryController,
    WarehouseController,
    ProductController,
    StockController
};

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('products', ProductController::class);

Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
Route::get('stocks/transfer', [StockController::class, 'transferForm'])->name('stocks.transfer.form');
Route::post('stocks/transfer', [StockController::class, 'transfer'])->name('stocks.transfer');