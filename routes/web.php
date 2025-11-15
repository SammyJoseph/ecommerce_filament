<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Payment\MPController;
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

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process_payment', [CheckoutController::class, 'process']);
Route::get('/thank-you', [CheckoutController::class, 'thanks'])->name('checkout.thanks');

Route::get('/payment/success', [MPController::class, 'success'])->name('payment.success');
Route::get('/payment/failure', [MPController::class, 'failure'])->name('payment.failure');
Route::get('/payment/pending', [MPController::class, 'pending'])->name('payment.pending');