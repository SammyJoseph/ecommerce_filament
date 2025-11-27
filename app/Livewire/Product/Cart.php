<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart as ShoppingCart;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

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
        $this->storeCart();
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        ShoppingCart::instance('shopping')->destroy();
        $this->storeCart();
        $this->dispatch('cart-updated');
    }

    private function storeCart()
    {
        if (Auth::check()) {
            ShoppingCart::store(Auth::user()->id);
        }
    }

    public function updateQuantity($rowId, $qty)
    {
        if ($qty <= 0) {
            $this->removeFromCart($rowId);
        } else {
            ShoppingCart::instance('shopping')->update($rowId, $qty);
            $this->dispatch('cart-updated');
        }
    }
}
