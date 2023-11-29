<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPromosController;
use App\Models\Promocode;
use Illuminate\Support\Facades\Route;



Route::get('/store/{store}', [StoreController::class, 'index']);

Route::get('/store/{store}/{action}', [StoreController::class, 'index']);

// Display form
Route::get('/store/{store}/create/listing/{action}', [StoreController::class, 'index']);
Route::post('/store/{store}/create/listing/{action}', [ProductController::class, 'store']);

// Route::get('/store/order/{order}', [OrderController::class, 'show']);