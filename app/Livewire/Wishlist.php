<?php

namespace App\Livewire;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

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

    use WithPagination;

    public function render()
    {
        $cartItems = Cart::instance('wishlist')->content();
        $perPage = 20;
        $page = $this->getPage();
        $total = $cartItems->count();

        $chunk = $cartItems->slice(($page - 1) * $perPage, $perPage);
        
        $productIds = $chunk->pluck('id')->toArray();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        
        $items = $chunk->map(function ($item) use ($products) {
            $product = $products->get($item->id);
            if (!$product) return null;

            return (object) [
                'rowId' => $item->rowId,
                'id' => $item->id,
                'product' => $product,
                'qty' => $item->qty,
                'price' => $item->price,
                'sale_price' => $item->sale_price,
                'image' => $product->getFirstMediaUrl('product_images', 'preview'),
            ];
        })->filter();

        $wishlistItems = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

        return view('livewire.wishlist', compact('wishlistItems'));
    }
}
