<?php

namespace App\Livewire;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wishlist extends Component
{
    public function mount()
    {
        // Si el usuario está autenticado, restaurar su wishlist
        if (Auth::check()) {
            Cart::instance('wishlist')->restore(Auth::id());
        }
    }

    public function removeFromWishlist($productId)
    {
        // Buscar el item en el wishlist por product ID
        $cartItem = Cart::instance('wishlist')->content()->firstWhere('id', $productId);
        
        if ($cartItem) {
            Cart::instance('wishlist')->remove($cartItem->rowId);
            $this->storeCart();
        }
    }

    public $confirmingItemDeletion = false;
    public $itemToDeleteId = null;

    public function confirmItemDeletion($productId)
    {
        $this->itemToDeleteId = $productId;
        $this->confirmingItemDeletion = true;
    }

    public function deleteItem()
    {
        $this->removeFromWishlist($this->itemToDeleteId);
        $this->confirmingItemDeletion = false;
        $this->itemToDeleteId = null;
        $this->dispatch('wishlist-updated');
    }

    private function storeCart()
    {
        if (Auth::check()) {
            Cart::instance('wishlist')->store(Auth::id());
        }
    }

    public function render()
    {
        $wishlistItems = [];
        
        if (Auth::check()) {
            // Obtener los items del wishlist desde Cart
            $cartItems = Cart::instance('wishlist')->content();
            
            // Cargar los productos asociados
            $productIds = $cartItems->pluck('id')->toArray();
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
            
            // Mapear los items del carrito con sus productos
            $wishlistItems = $cartItems->map(function ($item) use ($products) {
                return (object) [
                    'rowId' => $item->rowId,
                    'id' => $item->id,
                    'product' => $products->get($item->id),
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'sale_price' => $item->sale_price,
                    'image' => $products->get($item->id)->getFirstMediaUrl('product_images', 'preview'),
                ];
            });
        }

        return view('livewire.wishlist', compact('wishlistItems'));
    }
}
