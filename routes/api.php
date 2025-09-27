<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);
Route::post('/cart/calculate', [CartController::class, 'calculate']);
