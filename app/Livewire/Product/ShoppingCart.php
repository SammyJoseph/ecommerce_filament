<?php

namespace App\Livewire\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class ShoppingCart extends Component
{    
    #[On('couponApplied', 'cartUpdated', 'couponRemoved')]
    public function render()
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

        $grandTotal = max(0, $subtotal - $discount);

        return view('livewire.product.shopping-cart', [
            'cartSubtotal' => $subtotal,
            'cartDiscount' => $discount,
            'cartGrandTotal' => $grandTotal,
        ]);
    }
}