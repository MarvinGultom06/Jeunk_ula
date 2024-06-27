<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;

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

Route::get('products', [ProductController::class, 'index']);


Route::middleware('web')->group(function () {

    Route::post('/login', [LoginController::class, 'login_action']);
    Route::post('/register', [LoginController::class, 'register_action']);
    Route::get('/cart', [CartController::class, 'getCart'])->name('cart.get');
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/product/{productId}', [CartController::class, 'removeFromCart'])->name('cart.product.remove');
    Route::post('/cart/update/{itemId}', [CartController::class, 'update']);
    Route::post('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/profile', [UserController::class, 'show']);
    Route::post('/profile', [UserController::class, 'update']);
});
