<?php

namespace App\Livewire\Header;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;

class CartCount extends Component
{
    #[On('cart-updated')]
    public function render()
    {
        return view('livewire.header.cart-count');
    }
}
