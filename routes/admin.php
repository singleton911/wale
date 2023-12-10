<?php

use App\Http\Controllers\BugController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\DisputeController;
use App\Http\Controllers\EscrowController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\FeaturedController;
use App\Http\Controllers\MarketKeyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewStoreController;
use App\Http\Controllers\NotificationTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mime\MessageConverter;

// Middleware group for 'user' role
// Route::middleware(['role:admin'])->group(function () {

    // Index routes
    Route::get('/{users}', [UserController::class, 'index']);
    Route::get('/{stores}', [StoreController::class, 'index']);
    Route::get('/{products}', [ProductController::class, 'index']);
    Route::get('/{reviews}', [ReviewController::class, 'index']);
    Route::get('/{promotion}', [PromocodeController::class, 'index']);
    Route::get('/{featured}', [FeaturedController::class, 'index']);
    Route::get('/{orders}', [OrderController::class, 'index']);
    Route::get('/{servers}', [ServerController::class, 'index']);
    Route::get('/{wallets}', [WalletController::class, 'index']);
    Route::get('/{supports}', [SupportController::class, 'index']);
    Route::get('/{news}', [NewsController::class, 'index']);
    Route::get('/{affiliates}', [ReferralController::class, 'index']);
    Route::get('/{messages}', [MessageConverter::class, 'index']);
    Route::get('/{carts}', [CartController::class, 'index']);
    Route::get('/{categories}', [CategoryController::class, 'index']);
    Route::get('/{disputes}', [DisputeController::class, 'index']);
    Route::get('/{escrows}', [EscrowController::class, 'index']);
    Route::get('/{new_stores}', [NewStoreController::class, 'index']);
    Route::get('/{reports}', [ReportController::class, 'index']);
    Route::get('/{replies}', [ReplyController::class, 'index']);
    Route::get('/{faqs}', [FAQController::class, 'index']);
    Route::get('/{bugs}', [BugController::class, 'index']);
    Route::get('/{conversations}', [ConversationController::class, 'index']);
    Route::get('/{market_keys}', [MarketKeyController::class, 'index']);
    Route::get('/{notification_types}', [NotificationTypeController::class, 'index']);

    // Create new resource routes
    Route::get('/user/{name}/{user}',[UserController::class, 'showUser']);

    // Show res

// });
