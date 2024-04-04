<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReviewController;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout/{id}','logout');
    Route::post('user/{id}','show');
    Route::get('user/{id}/sold_items','sold_items');
    Route::get('user/{id}/purchase_items','purchase_items');
    Route::get('user/{id}/cart','get_cart');
    Route::get('user/{id}/listed_items','get_listed_items');
    Route::post('user/{id}/purchaseInfo/{shipTo:slug}/{currency:slug}','change_purchase_info');
});

Route::controller(ProductController::class)->group(function () {
    Route::post('product/create/user/{userId}/cate/{catId}','create'); // to create a product
    Route::get('product/{pordId}','show'); 
    Route::put('product/{pordId}/edit','edit'); 
    Route::delete('product/{pordId}/delete','delete');
    Route::get('product/search/{prod:slug}','search');  
    Route::get('products','all_prod');  
});
Route::controller(CategoryController::class)->group(function () {
    Route::post('category/create','create');
    Route::get('category/{cateId}','show'); 
    Route::put('category/{cateId}/edit','edit'); 
    Route::delete('category/{cateId}/delete','delete');
    Route::get('category/{categoryName:slug}/search/{pordName:slug}','search');  
});
Route::controller(PurchaseController::class)->group(function () {
    Route::post('purchase/{cartId}/to/{buyerId}','create');//always cartId == buyerId
    Route::get('purchase/{purchaseId}','show');
    Route::get('purchase/edit/{purchaseId}','edit');
    // Route::patch('purchase/edit/{purchaseId}','update');
    Route::delete('purchase/delete/{purchaseId}','delete');
});
Route::controller(CountryController::class)->group(function () {
    Route::post('coutries/add','add_countries');
    Route::get('coutrie/getMobileCode/{coountry:slug}','get_mobile_code');
    Route::get('coutries/all','all_countries');
});

Route::controller(MessageController::class)->group(function () {
    Route::post('message/create/{senderId}/{receiverId}','create');
    Route::get('message/{msgId}','show');
    Route::get('message/edit/{msgId}','edit');
    Route::patch('message/edit/{msgId}','update');
    Route::delete('message/delete/{msgId}','delete');
});

Route::controller(ReviewController::class)->group(function () {
    Route::post('review/create/{reviewerId}/{prodId}','create');
    Route::get('review/{reviewId}','show');
    Route::get('review/edit/{reviewId}','edit');
    Route::patch('review/edit/{reviewId}','update');
    Route::delete('review/delete/{reviewId}','delete');
});
Route::controller(CartController::class)->group(function () {
    Route::get('cart/{ownerId}','show');
    Route::post('cart/add/{ownerId}/{prodId}','add');
    Route::post('cart/remove/from/{ownerId}/{prodId}','remove');
});
