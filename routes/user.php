<?php

use App\Http\Controllers\BlockStoreController;
use App\Http\Controllers\BugController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\FavoriteListingController;
use App\Http\Controllers\FavoriteStoreController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewStoreController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['role:user'])->group(function () {

    Route::post('/', [UserController::class, 'show']);
    // search quick and advance
    Route::get('/search', [SearchController::class, 'quickSearch']);
    Route::get('/parent/category/{created_at}/{category}', [CategoryController::class, 'parentCategoryProducts']);
    Route::get('/sub/category/{created_at}/{category}', [CategoryController::class, 'subCategoryProducts']);

    // Get the qrcode
    Route::get('/account/deposit/qrcode', [GeneralController::class, 'qrcode']);

    Route::post('/account/pgp', [GeneralController::class, 'pgpKeySystem']);
    Route::post('/account/changePassword', [UserController::class, 'changePassword']);
    Route::post('/bugs', [BugController::class, 'store']);


    // Delete methods
    Route::delete('/blocked/b_store/{blockStore}', [BlockStoreController::class, 'destroy']);
    Route::delete('/favorite/f_store/{favoriteStore}', [FavoriteStoreController::class, 'destroy']);
    Route::delete('/favorite/f_listing/{favoriteListing}', [FavoriteListingController::class, 'destroy']);

    Route::post('/open-store', [UserController::class, 'openstore']);
    Route::get('/store/waiver', [NewStoreController::class, 'waiver']);
    Route::post('/store/waiver', [NewStoreController::class, 'waiverAdd']);


    // Store routes
    Route::get('/store/show/{name}/{store}', [StoreController::class, 'show']);
    Route::get('/store/show/pgp/{name}/{store}', [StoreController::class, 'pgp']);
    Route::get('/store/show/reviews/{name}/{store}', [StoreController::class, 'reviews']);
    Route::post('/store/show/report/{name}/{store}', [ReportController::class, 'storeUser']);
    Route::post('/store/show/{name}/{store}', [StoreController::class, 'checkAction']);
    Route::get('/open-store', [NewStoreController::class, 'create']);

    // Listings  
    Route::get('/listing/{created_at}/{product}', [ProductController::class, 'show']);
    Route::post('/listing/{created_at}/{product}', [ProductController::class, 'checkAction']);
    Route::post('/listing/report/{created_at}/{product}', [ReportController::class, 'listing']);
    Route::get('/listing/reviews/{created_at}/{product}', [ProductController::class, 'reviews']);

    // Messages for store
    Route::get('/store/show/message/{name}/{store}', [MessageController::class, 'create']);
    Route::post('/store/show/message/{name}/{store}', [ConversationController::class, 'store']);

    Route::post('/messages/{created_at}/{conversation}', [MessageController::class, 'store']);
    Route::get('/messages/{created_at}/{conversation}', [ConversationController::class, 'show']);
    Route::get('/messages', [MessageController::class, 'showMessages']);

    // Support and tickets
    Route::post('/ticket', [SupportController::class, 'create']);

    // Reports
    Route::get('/store/show/report/{name}/{id}', [ReportController::class, 'create']);
    Route::get('/listing/report/{name?}/{id}', [ReportController::class, 'create']);

    // Cart routes
    Route::get('/cart', [CartController::class, 'create']);
    Route::post('/cart', [CartController::class, 'createOrder']);
    Route::patch('/cart/{user}/{created_ta}/{cart}', [CartController::class, 'checkAction']);

    // Promo code route
    Route::post('/apply/promocode', [CartController::class, 'checkPromoInCart']);

    // order info 
    Route::get('/order/{created_at}/{order}', [OrderController::class, 'show']);
    Route::post('/order/{created_at}/{order}', [OrderController::class, 'update']);

    // Notifications 
    Route::post('/notification/{created_at}/{notification}', [NotificationController::class, 'update']);
    Route::get('/notification', [NotificationController::class, 'showNotifications']);
    Route::get('/canary', [GeneralController::class, 'canary']);

    // Tired Worth 
    Route::get('/faq', [FAQController::class, 'create']);
    Route::get('/news', [NewsController::class, 'create']);
    Route::get('/ticket', [SupportController::class, 'showTicket']);
    Route::get('/bugs', [BugController::class, 'create']);

    // User 
    Route::get('/{name}/{action}', [UserController::class, 'show']);
});
