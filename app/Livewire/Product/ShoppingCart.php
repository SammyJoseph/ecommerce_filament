<?php

namespace App\Livewire\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class ShoppingCart extends Component
{
    #[On('cart-updated')]
    public function render()
    {
        $cart = Cart::instance('shopping');

        return view('livewire.product.shopping-cart', compact('cart'));
    }
}
