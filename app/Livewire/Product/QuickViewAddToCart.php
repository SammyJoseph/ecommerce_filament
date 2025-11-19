<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class QuickViewAddToCart extends Component
{
    public function render()
    {
        return view('livewire.product.quick-view-add-to-cart');
    }

    public function addToCart($productId, $quantity, $variantData = null)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Producto no encontrado.']);
            return;
        }

        $quantity = max(1, (int) $quantity);

        if ($product->has_variants) {
            if (!$variantData || !isset($variantData['variant_id']) || !isset($variantData['variant_size_id'])) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Por favor selecciona color y talla.']);
                return;
            }

            // Verify stock (optional, but good practice)
            // We trust the frontend data for ID mapping but should verify existence/stock if critical
            // For speed, we'll use the passed IDs but maybe re-fetch price to be safe?
            // Let's use the IDs to fetch the actual DB records to ensure price integrity.
            
            $variant = $product->variants()->find($variantData['variant_id']);
            $variantSize = $variant ? $variant->sizes()->where('id', $variantData['variant_size_id'])->first() : null;

            if (!$variant || !$variantSize) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Variante no válida.']);
                return;
            }

            if ($variantSize->stock < $quantity) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Stock insuficiente.']);
                return;
            }

            $itemId = 'variant-' . $variant->id . '-size-' . $variantSize->id;
            $itemName = $product->name . ' - ' . $variant->color->value . ' / ' . $variantSize->size->value;
            $itemPrice = $variantSize->sale_price ?? $variantSize->price;
            $itemImage = $variantData['image'] ?? $product->getFirstMediaUrl('product_images', 'preview');

            Cart::instance('shopping')->add([
                'id' => $itemId,
                'name' => $itemName,
                'qty' => $quantity,
                'price' => $itemPrice,
                'options' => [
                    'image' => $itemImage,
                    'slug' => $product->slug,
                    'variant_id' => $variant->id,
                    'variant_size_id' => $variantSize->id,
                    'product_id' => $product->id,
                    'color' => $variant->color->value,
                    'size' => $variantSize->size->value,
                ],
            ]);

        } else {
            // Simple product
            $itemImage = $product->getFirstMediaUrl('product_images', 'preview');
            
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $quantity,
                'price' => $product->sale_price ?? $product->price,
                'options' => [
                    'image' => $itemImage,
                    'slug' => $product->slug,
                    'product_id' => $product->id,
                ],
            ]);
        }

        $this->dispatch('cart-updated');
        $this->dispatch('open-side-cart');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Producto agregado al carrito.']);
    }
}
