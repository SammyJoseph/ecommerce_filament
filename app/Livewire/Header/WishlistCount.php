<?php

namespace App\Livewire\Header;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;

class WishlistCount extends Component
{
    #[On('wishlist-updated')]
    public function render()
    {
        return view('livewire.header.wishlist-count');
    }
}
