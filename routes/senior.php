<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\SeniorController;
use Illuminate\Support\Facades\Route;




Route::get('/senior/staff/{user}/show/{action?}', [SeniorController::class, 'index']);

// User Users
Route::get('/senior/staff/show/user/{created_at}/{user}', [SeniorController::class, 'user']);
Route::post('/senior/staff/show/user/{created_at}/{user}', [SeniorController::class, 'banUnbanUser']);

// Store Stores
Route::get('/senior/staff/show/new store/{created_at}/{new_store}', [SeniorController::class, 'new_store']);
Route::post('/senior/staff/show/new store/{created_at}/{new_store}', [SeniorController::class, 'approveDeclineStore']);

Route::get('/senior/staff/show/product/{created_at}/{product}', [SeniorController::class, 'product']);

// Support ticket
Route::post('/senior/staff/chernoh/show/support', [SeniorController::class, 'joinSupport']);
Route::get('/senior/staff/show/ticket/{created_at}/{conversation}', [SeniorController::class, 'supportTicket']);
Route::post('/senior/staff/show/ticket/{created_at}/{conversation}', [MessageController::class, 'seniorModUser']);


