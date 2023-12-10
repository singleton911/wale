<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Other routes...
Route::get('/ddos', function () {
    return view('Auth.ddos', ['icon' => GeneralController::encodeImages()]);
});

Route::get('/', [UserController::class, 'show']);

// Authentication
Route::middleware(['guest'])->group(function () {
    //Route::get('/', [UserController::class, 'show']);
    Route::get('/auth/{action}/', [UserController::class, 'create']);
    Route::post('/auth/login', [UserController::class, 'authLogin']);
    Route::post('/auth/signup', [UserController::class, 'store']);
});

// Include user routes from user.php
require_once('user.php');


Route::middleware(['role:store'])->group(function () {
    // Include store routes from store.php
    require_once('store.php');
});

// Route::middleware(['role:admin'])->group(function () {
//     // Include admin routes from admin.php
//     require_once('admin.php');
// });



// });
Route::get('/logout', [UserController::class, 'userLogout']);
