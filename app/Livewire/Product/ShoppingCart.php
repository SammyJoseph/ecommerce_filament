<?php

namespace App\Livewire\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class ShoppingCart extends Component
{    
    public function render()
    {
        Cart::instance('shopping');
        $productsInCart = Cart::content();
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
            'productsInCart' => $productsInCart,
            'cartSubtotal' => $subtotal,
            'cartDiscount' => $discount,
            'cartGrandTotal' => $grandTotal,
        ]);
    }

    public function removeFromCart($rowId)
    {
        Cart::instance('shopping')->remove($rowId);
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        Cart::instance('shopping')->destroy();
        $this->dispatch('cart-updated');
    }

    public function updateQuantity($rowId, $qty)
    {
        if ($qty <= 0) {
            $this->removeFromCart($rowId);
        } else {
            Cart::instance('shopping')->update($rowId, $qty);
            $this->dispatch('cart-updated');
        }
    }

    #[On('removeCoupon')]
    public function removeCoupon()
    {
        session()->forget('coupon');
        $this->dispatch('couponRemoved');
        session()->flash('success', 'Cupón eliminado.');
    }

    #[On('cart-updated')] 
    #[On('couponApplied')]
    public function updateTotals()
    {
        // This method listens for events to trigger a re-render
    }
}