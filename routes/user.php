<?php

use App\Http\Controllers\BlockStoreController;
use App\Http\Controllers\BugController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FavoriteListingController;
use App\Http\Controllers\FavoriteStoreController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Models\FavoriteStore;
use Illuminate\Support\Facades\Route;



// Middleware group for 'user' role
Route::middleware(['role:user'])->group(function () {
    Route::post('/', [UserController::class, 'show']);
    // Dynamic routes
    Route::get('/{name}', [UserController::class, 'show']);
    Route::get('/category/{name}/{action}', [UserController::class, 'index']);

    Route::post('/account/pgp', [GeneralController::class, 'validateAndExtractInfo']);
    Route::post('/account/changePassword', [UserController::class, 'changePassword']);
    Route::post('/bugs', [BugController::class, 'store']);

    // Delete methods
    Route::delete('/blocked/b_store/{blockStore}', [BlockStoreController::class, 'destroy']);
    Route::delete('/favorite/f_store/{favoriteStore}', [FavoriteStoreController::class, 'destroy']);
    Route::delete('/favorite/f_listing/{favoriteListing}', [FavoriteListingController::class, 'destroy']);

    Route::get('/{name}/{action}', [UserController::class, 'show']);
    Route::post('/open-store', [UserController::class, 'openstore']);


    // Store routes
    Route::get('/store/{name}/{store}', [StoreController::class, 'show']);
    Route::get('/store/pgp/{name}/{store}', [StoreController::class, 'pgp']);
    Route::get('/store/reviews/{name}/{store}', [StoreController::class, 'reviews']);
    Route::post('/store/report/{name}/{store}', [ReportController::class, 'storeUser']);
    Route::post('/store/{name}/{store}', [StoreController::class, 'checkAction']);

    // Listings
    Route::get('/listing/{created_at}/{product}', [ProductController::class, 'show']);
    Route::post('/listing/{created_at}/{product}', [ProductController::class, 'checkAction']);
    Route::post('/listing/report/{created_at}/{product}', [ReportController::class, 'listing']);
    Route::get('/listing/reviews/{created_at}/{product}', [ProductController::class, 'reviews']);

    // Messages for store
    Route::get('/store/message/{name}/{store}', [MessageController::class, 'create']);
    Route::post('/store/message/{name}/{store}', [ConversationController::class, 'store']);

    Route::post('/messages/{created_at}/{conversation}', [MessageController::class, 'store']);
    Route::get('/messages/{created_at}/{conversation}', [ConversationController::class, 'show']);

    // Support and tickets
    Route::post('/ticket', [SupportController::class, 'create']);

    // Reports
    Route::get('/store/report/{name}/{id}', [ReportController::class, 'create']);
    Route::get('/listing/report/{name?}/{id}', [ReportController::class, 'create']);

    // Cart routes
    Route::post('/cart', [CartController::class, 'store']);
    Route::patch('/cart/{cart}', [CartController::class, 'checkAction']);

    // Promo code route
    Route::post('/apply/promocode', [CartController::class, 'checkPromoInCart']);

    // order info
    Route::get('/order/{created_at}/{order}', [OrderController::class, 'show']);
    Route::post('/order/{created_at}/{order}', [OrderController::class, 'update']);


    Route::post('/notification/{created_at}/{notification}', [NotificationController::class, 'update']);

});
