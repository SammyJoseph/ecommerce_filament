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

Route::get('/producto/{product}', [SiteController::class, 'productDetails'])->name('product.show');

Route::get('/', [SiteController::class, 'index'])->name('index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/mi-cuenta', [UserController::class, 'accountDetails'])->name('user.my-account');
    Route::post('/mi-cuenta/update', [UserController::class, 'updateAccountDetails'])->name('user.update-account');
    Route::get('/mi-cuenta/pedidos', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/mi-cuenta/pedidos/{order}', [UserController::class, 'orderDetails'])->name('user.order.details');
    Route::get('/mi-cuenta/direcciones', [UserController::class, 'address'])->name('user.address');
    Route::get('/mi-cuenta/metodos-de-pago', [UserController::class, 'paymentMethod'])->name('user.payment-method');
});

Route::get('/carrito', [CartController::class, 'index'])->name('cart');
Route::get('/raw-cart', function () {
    Cart::instance('shopping');
    $cart = Cart::content();

    return response()->json($cart);
});

Route::get('/tienda', [SiteController::class, 'shop'])->name('shop');
Route::get('/lista-de-deseos', [SiteController::class, 'wishlist'])->name('wishlist');
Route::get('/raw-wishlist', function () {
    Cart::instance('wishlist');
    $cart = Cart::content();

    return response()->json($cart);
});

Route::get('/pagar', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/pagar/process_payment', [CheckoutController::class, 'process']);
Route::get('/gracias', [CheckoutController::class, 'thanks'])->name('checkout.thanks');

Route::get('/payment/success', [MPController::class, 'success'])->name('payment.success');
Route::get('/payment/failure', [MPController::class, 'failure'])->name('payment.failure');
Route::get('/payment/pending', [MPController::class, 'pending'])->name('payment.pending');

Route::post('/mp/webhook', [MPController::class, 'webhook'])->name('mp.webhook');

Route::get('/nosotros', [SiteController::class, 'about'])->name('about');
Route::get('/contacto', [SiteController::class, 'contact'])->name('contact');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/preview/{token}', [BlogController::class, 'preview'])->name('blog.preview');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/categories', [BlogController::class, 'blogCategoryIndex'])->name('blog.category.index');
Route::get('/blog/category/{category}', [BlogController::class, 'blogCategoryShow'])->name('blog.category.show');

Route::get('/demo', [DocumentationController::class, 'index'])->name('doc');
Route::get('/demo/login/buyer', [DocumentationController::class, 'loginBuyer'])->name('doc.login.buyer');
Route::get('/demo/login/admin', [DocumentationController::class, 'loginAdmin'])->name('doc.login.admin');

Route::get('/email-order', function () {
    $order = \App\Models\Order::with(['user', 'orderItems.product'])->latest()->first();
    
    if (!$order) {
        return "No hay órdenes para mostrar.";
    }

    return new \App\Mail\OrderStatusChanged($order);
});
Route::get('/email-welcome', function () {
    $user = \App\Models\User::first();

    if (!$user) {
        return "No hay usuarios para mostrar.";
    }

    return new \App\Mail\WelcomeEmail($user);
});
