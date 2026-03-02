<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::post('/products/update', [ProductController::class, 'update'])->name('products.update'); 
Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
