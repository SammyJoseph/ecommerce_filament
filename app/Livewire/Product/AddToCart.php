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
    public $selectedVariant = null;

    public function mount(?Product $product = null, int $quantity = 1, string $classes = '')
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->classes = $classes;

        // If product has variants, select the first visible one
        if ($this->product && $this->product->variants->count() > 0) {
            $this->selectedVariant = $this->product->variants->where('is_visible', true)->first();
        }
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

        $itemId = $this->selectedVariant ? $this->selectedVariant->id : $this->product->id;
        $itemName = $this->selectedVariant ? $this->product->name . ' - ' . $this->selectedVariant->name : $this->product->name;
        $itemPrice = $this->selectedVariant ? ($this->selectedVariant->price ?? $this->product->price) : $this->product->price;
        $itemImage = $this->selectedVariant
            ? $this->selectedVariant->getFirstMediaUrl('variant_images', 'preview')
            : $this->product->getFirstMediaUrl('product_images', 'preview');

        try {
            Cart::instance('shopping')->add([
                'id' => $itemId,
                'name' => $itemName,
                'qty' => $this->quantity,
                'price' => $itemPrice,
                'options' => [
                    'image' => $itemImage,
                    'slug' => $this->product->slug,
                    'variant_id' => $this->selectedVariant?->id,
                    'product_id' => $this->product->id,
                ],
            ]);

            $this->dispatch('cart-updated');
            $this->dispatch('open-side-cart');
            session()->flash('success', 'Producto agregado al carrito.');
        } catch (\Exception $e) {
            Log::error('Error al agregar producto al carrito', [
                'product_id' => $this->product->id,
                'variant_id' => $this->selectedVariant?->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Error al agregar el producto al carrito.');
        }
    }

    public function selectVariant($variantId)
    {
        $this->selectedVariant = $this->product->variants->find($variantId);
    }
}
