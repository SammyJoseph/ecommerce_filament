<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class AddToCart extends Component
{
    public ?Product $product = null;

    public function render()
    {
        return view('livewire.product.add-to-cart');
    }

    public function addToCart()
    {
        Cart::instance('shopping');

        $product = Product::find($this->product->id);
        if ($product) {
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => [
                    'image' => $product->getFirstMediaUrl('product_images', 'preview'),
                    'slug' => $product->slug,
                ],
            ]);

            $this->dispatch('open-minicart');
            session()->flash('success', 'Producto agregado al carrito.');
        } else {
            session()->flash('error', 'Producto no encontrado.');
        }
    }
}
