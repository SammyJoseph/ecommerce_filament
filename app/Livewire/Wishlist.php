<?php

namespace App\Livewire;

use App\Models\Wishlist as WishlistModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wishlist extends Component
{
    public function removeFromWishlist($wishlistId)
    {
        $wishlist = WishlistModel::where('id', $wishlistId)->where('user_id', Auth::id())->first();

        if ($wishlist) {
            $wishlist->delete();
        }
    }

    public function render()
    {
        $wishlistItems = [];
        
        if (Auth::check()) {
            $wishlistItems = WishlistModel::where('user_id', Auth::id())
                ->with('product')
                ->get();
        }

        return view('livewire.wishlist', compact('wishlistItems'));
    }
}
