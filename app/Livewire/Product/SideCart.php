<?php

namespace App\Livewire\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SideCart extends Component
{
    public $isOpen = false;
    
    public function increaseQuantity($rowId)
    {
        $cartItem = Cart::instance('shopping')->get($rowId);
        $newQuantity = $cartItem->qty + 1;
        Cart::instance('shopping')->update($rowId, $newQuantity);
    }

    public function decreaseQuantity($rowId)
    {
        $cartItem = Cart::instance('shopping')->get($rowId);
        $newQuantity = $cartItem->qty > 1 ? $cartItem->qty - 1 : 1;
        Cart::instance('shopping')->update($rowId, $newQuantity);
    }

    #[On('cart-updated')]
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

        return view('livewire.product.side-cart', compact('productsInCart', 'subtotal', 'discount', 'grandTotal'));
    }

    #[On('open-side-cart')] 
    public function openCart()
    {
        $this->isOpen = true;
        $this->dispatch('body-overlay', active: true);
    }

    #[On('close-side-cart')]
    public function closeCart()
    {
        $this->isOpen = false;
        $this->dispatch('body-overlay', active: false);
    }

    #[On('open-minicart')] 
    public function openMiniCart()
    {
        $this->isOpen = true;
    }

    public function removeFromCart($rowId)
    {
        Cart::instance('shopping')->remove($rowId);
        $this->storeCart();
        $this->dispatch('cart-updated');
    }

    private function storeCart()
    {
        if (Auth::check()) {
            Cart::store(Auth::user()->id);
        }
    }
}
