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
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Rutas externas y Webhooks (sin prefijo de idioma ni traducción)
Route::post('/mp/webhook', [MPController::class, 'webhook'])->name('mp.webhook');
Route::get('/payment/success', [MPController::class, 'success'])->name('payment.success');
Route::get('/payment/failure', [MPController::class, 'failure'])->name('payment.failure');
Route::get('/payment/pending', [MPController::class, 'pending'])->name('payment.pending');

// Rutas del Ecommerce Localizadas y Traducidas
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localize' ]
], function () {

    Route::get('/', [SiteController::class, 'index'])->name('index');
    Route::get(LaravelLocalization::transRoute('routes.product_show'), [SiteController::class, 'productDetails'])->name('product.show');
    Route::get(LaravelLocalization::transRoute('routes.shop_index'), [SiteController::class, 'shop'])->name('shop.index');
    Route::get(LaravelLocalization::transRoute('routes.shop_category'), [SiteController::class, 'shopCategory'])->name('shop.category');
    Route::get(LaravelLocalization::transRoute('routes.cart'), [CartController::class, 'index'])->name('cart');
    Route::get(LaravelLocalization::transRoute('routes.wishlist'), [SiteController::class, 'wishlist'])->name('wishlist');
    Route::get(LaravelLocalization::transRoute('routes.checkout_index'), [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post(LaravelLocalization::transRoute('routes.checkout_index') . '/process_payment', [CheckoutController::class, 'process']);
    Route::get(LaravelLocalization::transRoute('routes.checkout_thanks'), [CheckoutController::class, 'thanks'])->name('checkout.thanks');
    Route::get(LaravelLocalization::transRoute('routes.about'), [SiteController::class, 'about'])->name('about');
    Route::get(LaravelLocalization::transRoute('routes.contact'), [SiteController::class, 'contact'])->name('contact');
    Route::get(LaravelLocalization::transRoute('routes.search'), [SiteController::class, 'search'])->name('search');

    // Rutas del Blog
    Route::get(LaravelLocalization::transRoute('routes.blog_index'), [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/preview/{token}', [BlogController::class, 'preview'])->name('blog.preview');
    Route::get(LaravelLocalization::transRoute('routes.blog_show'), [BlogController::class, 'show'])->name('blog.show');
    Route::get(LaravelLocalization::transRoute('routes.blog_category_index'), [BlogController::class, 'blogCategoryIndex'])->name('blog.category.index');
    Route::get(LaravelLocalization::transRoute('routes.blog_category_show'), [BlogController::class, 'blogCategoryShow'])->name('blog.category.show');

    // Rutas de Usuario Autenticado
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get(LaravelLocalization::transRoute('routes.user_my_account'), [UserController::class, 'accountDetails'])->name('user.my-account');
        Route::post(LaravelLocalization::transRoute('routes.user_my_account') . '/update', [UserController::class, 'updateAccountDetails'])->name('user.update-account');
        Route::get(LaravelLocalization::transRoute('routes.user_orders'), [UserController::class, 'orders'])->name('user.orders');
        Route::get(LaravelLocalization::transRoute('routes.user_order_details'), [UserController::class, 'orderDetails'])->name('user.order.details');
        Route::get(LaravelLocalization::transRoute('routes.user_address'), [UserController::class, 'address'])->name('user.address');
        Route::get(LaravelLocalization::transRoute('routes.user_payment_method'), [UserController::class, 'paymentMethod'])->name('user.payment-method');
    });

    // Rutas internas de utilidad (JSON)
    Route::get('/raw-cart', function () {
        Cart::instance('shopping');
        $cart = Cart::content();
        return response()->json($cart);
    });
    Route::get('/raw-wishlist', function () {
        Cart::instance('wishlist');
        $cart = Cart::content();
        return response()->json($cart);
    });

    // Rutas de Demo/Doc
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
});
