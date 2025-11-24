<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Payment\MPController;
use App\Http\Controllers\Product\CartController;
use App\Http\Controllers\UserController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

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

    Route::get('/my-account', [UserController::class, 'myAccount'])->name('user.my-account');
    Route::get('/my-account/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/my-account/order/{order}', [UserController::class, 'orderDetails'])->name('user.order.details');
    Route::get('/my-account/address', [UserController::class, 'address'])->name('user.address');
    Route::get('/my-account/details', [UserController::class, 'accountDetails'])->name('user.details');
    Route::get('/my-account/download', [UserController::class, 'download'])->name('user.download');
    Route::get('/my-account/payment-method', [UserController::class, 'paymentMethod'])->name('user.payment-method');
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

Route::post('/mp/webhook', [MPController::class, 'webhook'])->name('mp.webhook');