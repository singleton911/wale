<?php

use App\Http\Controllers\DisputeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SeniorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/senior/staff/{user}/show/theme', [UserController::class, 'theme']);

Route::get('/senior/staff/{user}/show/{action?}', [SeniorController::class, 'index']);

// User Users
Route::get('/senior/staff/show/user/{created_at}/{user}', [SeniorController::class, 'user']);
Route::post('/senior/staff/show/user/{created_at}/{user}', [SeniorController::class, 'banUnbanUser']);


// Store Stores
Route::get('/senior/staff/show/new store/{created_at}/{new_store}', [SeniorController::class, 'new_store']);
Route::post('/senior/staff/show/new store/{created_at}/{new_store}', [SeniorController::class, 'approveDeclineStore']);

Route::get('/senior/staff/show/store/{created_at}/{store}', [SeniorController::class, 'store']);
Route::post('/senior/staff/show/store/{created_at}/{store}', [SeniorController::class, 'approveDeclineStore']);

Route::get('/senior/staff/show/product/{created_at}/{product}', [SeniorController::class, 'product']);

// Support ticket
Route::post('/senior/staff/{user}/show/support', [SeniorController::class, 'joinSupport']);
Route::get('/senior/staff/show/ticket/{created_at}/{conversation}', [SeniorController::class, 'supportTicket']);
Route::post('/senior/staff/show/ticket/{created_at}/{conversation}', [MessageController::class, 'seniorModUser']);


// Disputes
Route::get('/senior/staff/{user}/show/dispute/{created_at}/{dispute}', [DisputeController::class, 'disputeShow']);
Route::post('/senior/staff/{user}/do/dispute/{created_at}/{dispute}', [DisputeController::class, 'disputeDo']);
