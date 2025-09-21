<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\Product\CartController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

Route::get('/index1', [IndexController::class, 'index'])->name('index');
Route::get('/product/{product}', [IndexController::class, 'productDetails'])->name('product.details');

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/raw-cart', function () {
    Cart::instance('shopping');
    $cart = Cart::content();
    return response()->json($cart);
});