<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class QuickViewModal extends Component
{
    public ?Product $product = null;
    public bool $isOpen = false;
    public $quantity = 1;

    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    #[On('populate-modal')]
    public function openModal($productId = null)
    {
        if (!$productId) {
             Log::error('productId no proporcionado');
             return;
        }

        try {
            $this->product = Product::with('media')->findOrFail($productId);
            $this->isOpen = true;

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             Log::warning('Producto no encontrado para quick view: ID ' . $productId);
        } catch (\Exception $e) {
            Log::error('Error al cargar producto en quick view: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.product.quick-view-modal');
    }
}
