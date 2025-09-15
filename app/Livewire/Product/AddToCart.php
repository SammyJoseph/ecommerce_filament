<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AddToCart extends Component
{
    public ?Product $product = null;
    public $quantity = 1;
    public $classes;

    public function mount(?Product $product = null, int $quantity = 1, string $classes = '')
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->classes = $classes;
    }

    public function render()
    {
        return view('livewire.product.add-to-cart');
    }

    public function addToCart()
    {
        if (!$this->product) {
            session()->flash('error', 'Producto no encontrado.');
            return;
        }
    
        try {
            Cart::instance('shopping')->add([
                'id' => $this->product->id,
                'name' => $this->product->name,
                'qty' => $this->quantity,
                'price' => $this->product->price,
                'options' => [
                    'image' => $this->product->getFirstMediaUrl('product_images', 'preview'),
                    'slug' => $this->product->slug,
                ],
            ]);
    
            $this->dispatch('cart-updated');
            $this->dispatch('open-side-cart');
            session()->flash('success', 'Producto agregado al carrito.');
        } catch (\Exception $e) {
            Log::error('Error al agregar producto al carrito', [
                'product_id' => $this->product->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Error al agregar el producto al carrito.');
        }
    }
}
