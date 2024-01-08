<?php

use App\Http\Controllers\BugController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShareAccessController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Support
Route::post('/store/{store}/do/support', [SupportController::class, 'storeCreate']);

// 2fa enable
Route::get('/auth/store/pgp/verify', [UserController::class, 'pgpVerify']);
Route::post('/auth/store/pgp/verify', [UserController::class, 'pgpCodeVerify']);

// themes
Route::get('/store/{store}/show/theme', [StoreController::class, 'theme']);

// catpcha
Route::get('/user/store/captcha', [GeneralController::class, 'captcha']);

// report bugs
Route::post('/store/{store}/do/bugs', [BugController::class, 'store']);

Route::get('/store/{actionName}/show/{action}', [StoreController::class, 'ShowAction']);
//Route::get('/{actionName}/products', [StoreController::class, 'ShowAction']);
Route::get('/store/{actionName}/show', [StoreController::class, 'index']);
Route::post('/store/{actionName}/do', [StoreController::class, 'storeAction']);

Route::post('/store/{store}/update/settings', [StoreController::class, 'update']);

Route::post('/store/{store}/do/pgp', [GeneralController::class, 'userPgpSystem']);
Route::post('/store/{store}/verify/pgp', [GeneralController::class, 'pgpKeySystem']);


// Route::get('/store/{store}/{action}', [StoreController::class, 'ShowAction']);
Route::post('/store/{name}/do/messages/{created_at}/{conversation}', [MessageController::class, 'storeUser']);
Route::get('/store/{name}/show/messages/{created_at}/{conversation}', [ConversationController::class, 'showStore']);
Route::post('/store/{store}/do/notification/{created_at}/{notification}', [NotificationController::class, 'updateStore']);

// add store note to order 
Route::post('/store/{store}/order/note/{created_at}/{order}', [OrderController::class, 'addStoreNote']);

// order info
Route::get('/store/{store}/show/order/{created_at}/{order}', [OrderController::class, 'showStoreOrder']);
Route::post('/store/{Store}/do/order/{created_at}/{order}', [StoreController::class, 'storeAction']);

// Display form
Route::get('/store/{store}/show/create/listing/{action}', [ProductController::class, 'create']);
Route::post('/store/{store}/do/create/listing/{action}', [ProductController::class, 'store']);

Route::get('/store/{store}/show/product-edit/{created_at}/{product}', [ProductController::class, 'edit']);
Route::post('/store/{store}/do/product-edit/{created_at}/{product}', [ProductController::class, 'update']);

// pasue and unpause 
Route::post('/store/{store}/do/product', [ProductController::class, 'productStatus']);

Route::get('/store/{store}/show/view/{created_at}/{product}', [ProductController::class, 'singleView']);
Route::post('/store/{store}/do/view/{created_at}/{product}', [ProductController::class, 'productStatus']);

// Share access 
Route::post('/store/{store}/show/share-access/', [ShareAccessController::class, 'create']);

// Coupons code
Route::post('/store/{store}/show/coupons', [PromocodeController::class, 'create']);


// Reply reviews
Route::post('/store/{store}/show/reply/review/{created_at}/{review}', [ReplyController::class, 'create']);


// Store Message user
Route::get('/store/message/user/{user}/{timestamp}/{order}', [StoreController::class, 'messageUser']);
Route::post('/store/message/user/{user}/{timestamp}/{order}', [StoreController::class, 'messageUser']);

// search routes
Route::get('/store/{actionName}/show/products/search', [SearchController::class, 'storeProductsSearch']);
Route::get('/store/{actionName}/show/orders/search', [SearchController::class, 'storeOrdersSearch']);



/// none 2fa routes
Route::get('/store/{actionName}/show/notifications/search', [SearchController::class, 'storeNotificationsSearch']);