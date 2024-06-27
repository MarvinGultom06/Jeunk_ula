<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
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

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware(['web'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/detail', function () {
            return view('detail');
        })->name('detail');

        Route::get('/cart', function () {
            return view('cart');
        })->name('cart');
        Route::get('/profile', function () {
            return view('profile');
        })->name('profile');
        Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::post('/checkout/success', [CheckoutController::class, 'success'])->name('order.success');
    });
});

Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});
