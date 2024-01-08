<?php

use App\Http\Controllers\DisputeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;




Route::get('/whales/admin/{user}/show/{action?}', [AdminController::class, 'index']);

// User Users
Route::get('/whales/admin/show/user/{created_at}/{user}', [AdminController::class, 'user']);
Route::post('/whales/admin/show/user/{created_at}/{user}', [AdminController::class, 'banUnbanUser']);

// Store Stores
Route::get('/whales/admin/show/new store/{created_at}/{new_store}', [AdminController::class, 'new_store']);
Route::post('/whales/admin/show/new store/{created_at}/{new_store}', [AdminController::class, 'approveDeclineStore']);

Route::get('/whales/admin/show/product/{created_at}/{product}', [AdminController::class, 'product']);

// Support ticket
Route::post('/whales/admin/{user}/show/support', [AdminController::class, 'joinSupport']);
Route::get('/whales/admin/show/ticket/{created_at}/{conversation}', [AdminController::class, 'supportTicket']);
Route::post('/whales/admin/show/ticket/{created_at}/{conversation}', [AdminController::class, 'seniorModUser']);


// Disputes
Route::get('/whales/admin/{user}/show/dispute/{created_at}/{dispute}', [DisputeController::class, 'disputeShow']);
Route::post('/whales/admin/{user}/do/dispute/{created_at}/{dispute}', [DisputeController::class, 'disputeDo']);
