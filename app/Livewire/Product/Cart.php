<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart as ShoppingCart;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class Cart extends Component
{
    #[On('cart-updated')]
    public function render()
    {
        $productsInCart = ShoppingCart::instance('shopping')->content();

        return view('livewire.product.cart', compact('productsInCart'));
    }

    public function removeFromCart($rowId)
    {
        ShoppingCart::instance('shopping')->remove($rowId);
        $this->dispatch('cartUpdated');
    }

    public function clearCart()
    {
        ShoppingCart::instance('shopping')->destroy();
        $this->dispatch('cartUpdated');
    }
}
