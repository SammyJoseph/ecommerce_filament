<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class WishlistToggle extends Component
{
    public $productId;
    public $isInWishlist = false;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->checkWishlistStatus();
    }

    public function checkWishlistStatus()
    {
        if (Auth::check()) {
            // Restore cart for checking status. 
            // Note: In high traffic, restoring repeatedly might be inefficient, 
            // but we follow Shop.php pattern here.
            Cart::instance('wishlist')->restore(Auth::id());
        }
        
        $this->isInWishlist = Cart::instance('wishlist')->content()->contains('id', $this->productId);
    }

    public function toggleWishlist()
    {
        $product = Product::findOrFail($this->productId);
    
        $cartItem = Cart::instance('wishlist')->content()->firstWhere('id', $this->productId);
        
        if ($cartItem) {
            Cart::instance('wishlist')->remove($cartItem->rowId);
            $this->isInWishlist = false;
        } else {
            Cart::instance('wishlist')->add([
                'id'    => $product->id,
                'name'  => $product->name,
                'qty'   => 1,
                'price' => $product->price,
                'options' => [
                    'image' => $product->getFirstMediaUrl('product_images', 'preview'),
                ],
            ]);
            $this->isInWishlist = true;
        }

        $this->storeCart();
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
        return view('livewire.product.wishlist-toggle');
    }
}
