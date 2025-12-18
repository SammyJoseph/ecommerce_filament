<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\VariantSize;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public ?Product $product = null;
    public $quantity = 1;
    public $divClasses, $classes;
    public $selectedColorId = null;
    public $selectedSizeId = null;
    public $variantCombinations = [];
    public $availableSizes = [];
    public $showIcon = true;

    public function mount(?Product $product = null, string $divClasses = '', string $classes = '', bool $showIcon = true)
    {
        $this->product = $product;
        $this->divClasses = $divClasses;
        $this->classes = $classes;
        $this->showIcon = $showIcon;

        // Get variant combinations for products with variants
        if ($this->product && $this->product->has_variants) {
            $this->variantCombinations = $this->product->getVariantCombinations();
            
            // Auto-select first color if available
            if (!empty($this->variantCombinations['colors'])) {
                $firstColor = array_key_first($this->variantCombinations['colors']);
                $this->selectColor($firstColor);
            }
        }
    }

    public function selectColor($colorValue)
    {
        // Find the color ID from the combinations
        if (isset($this->variantCombinations['colors'][$colorValue])) {
            $colorData = $this->variantCombinations['colors'][$colorValue];
            
            // Find variant with this color
            $variant = $this->product->variants()
                ->whereHas('color', function($query) use ($colorValue) {
                    $query->where('value', $colorValue);
                })
                ->first();

            if ($variant) {
                $this->selectedColorId = $variant->color_id;
                $this->availableSizes = $colorData['available_sizes'] ?? [];
                
                // Reset size selection when color changes
                $this->selectedSizeId = null;
            }
        }
    }

    public function selectSize($sizeValue)
    {
        // Find size ID from available sizes
        $sizeOption = $this->product->options()->where('type', 'size')->first();
        if ($sizeOption) {
            $sizeOptionValue = $sizeOption->values()->where('value', $sizeValue)->first();
            if ($sizeOptionValue) {
                $this->selectedSizeId = $sizeOptionValue->id;
            }
        }
    }

    public function render()
    {
        return view('livewire.product.add-to-cart');
    }

    public function addToCart($quantity = 1)
    {
        if (!$this->product) {
            session()->flash('error', 'Producto no encontrado.');
            return;
        }

        // Set quantity from parameter
        $this->quantity = max(1, (int) $quantity);

        // For products with variants
        if ($this->product->has_variants) {
            if (!$this->selectedColorId || !$this->selectedSizeId) {
                session()->flash('error', 'Por favor selecciona color y talla.');
                return;
            }

            // Find the variant by color
            $variant = $this->product->variants()->where('color_id', $this->selectedColorId)->first();
            
            if (!$variant) {
                session()->flash('error', 'Variante no encontrada.');
                return;
            }

            // Find the specific size for this variant
            $variantSize = $variant->sizes()
                ->where('product_option_value_id', $this->selectedSizeId)
                ->first();

            if (!$variantSize) {
                session()->flash('error', 'Talla no disponible para este color.');
                return;
            }

            if ($variantSize->stock < $this->quantity) {
                session()->flash('error', 'Stock insuficiente.');
                return;
            }

            // Get color and size names for display
            $colorName = $variant->color ? $variant->color->value : '';
            $sizeName = $variantSize->size ? $variantSize->size->value : '';

            $itemId = 'variant-' . $variant->id . '-size-' . $variantSize->id;
            $itemName = $this->product->name . ' - ' . $colorName . ' / ' . $sizeName;
            $itemPrice = $variantSize->sale_price ?? $variantSize->price;
            $itemImage = $variant->getFirstMediaUrl('variant_images', 'preview') 
                ?: $this->product->getFirstMediaUrl('product_images', 'preview');

            try {
                Cart::instance('shopping')->add([
                    'id' => $itemId,
                    'name' => $itemName,
                    'qty' => $this->quantity,
                    'price' => $itemPrice,
                    'options' => [
                        'image' => $itemImage,
                        'slug' => $this->product->slug,
                        'variant_id' => $variant->id,
                        'variant_size_id' => $variantSize->id,
                        'product_id' => $this->product->id,
                        'color' => $colorName,
                        'size' => $sizeName,
                    ],
                ]);

                $this->dispatch('cart-updated');
                $this->dispatch('open-side-cart');
                session()->flash('success', 'Producto agregado al carrito.');
            } catch (\Exception $e) {
                Log::error('Error al agregar producto al carrito', [
                    'product_id' => $this->product->id,
                    'variant_id' => $variant->id,
                    'variant_size_id' => $variantSize->id,
                    'error' => $e->getMessage()
                ]);
                session()->flash('error', 'Error al agregar el producto al carrito.');
            }
        } else {
            // For products without variants
            $itemImage = $this->product->getFirstMediaUrl('product_images', 'preview');

            try {
                Cart::instance('shopping')->add([
                    'id' => $this->product->id,
                    'name' => $this->product->name,
                    'qty' => $this->quantity,
                    'price' => $this->product->sale_price ?? $this->product->price,
                    'options' => [
                        'image' => $itemImage,
                        'slug' => $this->product->slug,
                        'product_id' => $this->product->id,
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

        if (Auth::check()) {
            Cart::store(Auth::user()->id);
        }
    }
}
