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

    #[On('populate-modal')]
    public function openModal($productId = null)
    {
        Log::info('Abriendo modal con productId:', ['productId' => $productId]);

        if (!$productId) {
             Log::error('productId no proporcionado');
             return;
        }

        try {
            $this->product = Product::with('media')->findOrFail($productId);
            $this->isOpen = true;

            Log::info('Producto cargado:', [
                'id' => $this->product->id,
                'name' => $this->product->name
            ]);

            $this->dispatch('quick-view-modal-loaded');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             Log::warning('Producto no encontrado para quick view: ID ' . $productId);
        } catch (\Exception $e) {
            Log::error('Error al cargar producto en quick view: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {        
        $this->product = null;
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.product.quick-view-modal');
    }
}
