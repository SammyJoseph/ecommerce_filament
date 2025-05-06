<?php

namespace App\Livewire\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

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

    public function render()
    {
        Cart::instance('shopping');
        $productsInCart = Cart::content();

        return view('livewire.product.side-cart', compact('productsInCart'));
    }

    #[On('open-minicart')] 
    public function openMiniCart()
    {
        $this->isOpen = true;
    }

    public function removeFromCart($rowId)
    {
        Cart::instance('shopping')->remove($rowId);
    }
}
