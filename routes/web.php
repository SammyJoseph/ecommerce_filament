<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\Payment\MPController;
use App\Http\Controllers\Product\CartController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

Route::get('/product/{product}', [SiteController::class, 'productDetails'])->name('product.show');

Route::get('/', [SiteController::class, 'index'])->name('index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/my-account', [UserController::class, 'accountDetails'])->name('user.my-account');
    Route::post('/my-account/update', [UserController::class, 'updateAccountDetails'])->name('user.update-account');
    Route::get('/my-account/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/my-account/order/{order}', [UserController::class, 'orderDetails'])->name('user.order.details');
    Route::get('/my-account/address', [UserController::class, 'address'])->name('user.address');
    Route::get('/my-account/payment-method', [UserController::class, 'paymentMethod'])->name('user.payment-method');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/raw-cart', function () {
    Cart::instance('shopping');
    $cart = Cart::content();

    return response()->json($cart);
});

Route::get('/shop', [SiteController::class, 'shop'])->name('shop');
Route::get('/wishlist', [SiteController::class, 'wishlist'])->name('wishlist');
Route::get('/raw-wishlist', function () {
    Cart::instance('wishlist');
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

Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/preview/{token}', [BlogController::class, 'preview'])->name('blog.preview');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/categories', [BlogController::class, 'blogCategoryIndex'])->name('blog.category.index');
Route::get('/blog/category/{category}', [BlogController::class, 'blogCategoryShow'])->name('blog.category.show');

Route::get('/demo', [DocumentationController::class, 'index'])->name('doc');
Route::get('/demo/login/buyer', [DocumentationController::class, 'loginBuyer'])->name('doc.login.buyer');
Route::get('/demo/login/admin', [DocumentationController::class, 'loginAdmin'])->name('doc.login.admin');
