<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product; // Asegúrate de importar tu modelo Product
use Livewire\Attributes\On; // Para Livewire 3+

class QuickViewModal extends Component
{
    public ?Product $product = null;
    public bool $showModal = true;

    // Escucha el evento 'showQuickView' disparado desde la lista de productos
    #[On('showQuickView')]
    public function loadProduct($productId)
    {
        // Carga el producto con sus relaciones necesarias (ej. media)
        $this->product = Product::with('media')->find($productId);

        if ($this->product) {
            $this->showModal = true;
            // Disparamos un evento para que JS/Alpine pueda re-inicializar librerías si es necesario
            $this->dispatch('quick-view-modal-loaded');
        } else {
            // Manejar caso de producto no encontrado si es necesario
            $this->showModal = false;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->product = null; // Limpia el producto al cerrar
    }

    public function render()
    {
        return view('livewire.product.quick-view-modal');
    }
}
