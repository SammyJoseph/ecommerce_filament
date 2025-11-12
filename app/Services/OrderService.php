<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public static function createOrderFromCart(): Order
    {
        Cart::instance('shopping');

        $subtotal = (float) str_replace(',', '', Cart::subtotal());
        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session('coupon');

            if ($coupon['type'] === 'fixed') {
                $discount = $coupon['value'];
            } elseif ($coupon['type'] === 'percentage') {
                $discount = ($subtotal * $coupon['value']) / 100;
            }
        }

        $total = max(0, $subtotal - $discount);

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => null,
        ]);

        foreach (Cart::content() as $item) {
            // Parse product_id from cart item id (e.g., 'variant-8-size-11' -> 8)
            if (preg_match('/variant-(\d+)/', $item->id, $matches)) {
                $productId = $matches[1];
            } else {
                $productId = $item->id;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item->qty,
                'price' => $item->price,
            ]);
        }

        Cart::destroy();
        session()->forget('coupon');

        return $order;
    }
}