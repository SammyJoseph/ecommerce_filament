<?php

namespace App\Livewire\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class IncreaseDecrease extends Component
{
    public $rowId;
    public $quantity;

    public function mount($rowId, $quantity)
    {
        $this->rowId = $rowId;
        $this->quantity = $quantity;
    }

    public function decreaseQuantity()
    {
        $this->quantity = $this->quantity > 1 ? $this->quantity - 1 : 1;
        Cart::instance('shopping')->update($this->rowId, $this->quantity);
        $this->dispatch('cart-updated');
    }

    public function increaseQuantity()
    {
        $this->quantity++;
        Cart::instance('shopping')->update($this->rowId, $this->quantity);
        $this->dispatch('cart-updated');
    }
    
    public function render()
    {
        return view('livewire.product.increase-decrease');
    }
}
