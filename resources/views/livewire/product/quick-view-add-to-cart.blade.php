<div>
    <div class="pro-details-add-to-cart tw-inline-block">
        <a title="Add to Cart" href="#" 
           @click.prevent="
                if (product.has_variants && (!selectedColor || !selectedSize)) {
                    $wire.$toggle('showValidationModal');
                    return;
                }
                let variantData = null;
                if (product.has_variants) {
                    const key = selectedColor + '-' + selectedSize;
                    variantData = product.variant_combinations.combinations[key];
                }
                $wire.addToCart(product.id, parseInt(document.getElementById('quick-view-quantity').value), variantData);
           ">
           <span wire:loading.remove wire:target="addToCart">Agregar</span>
           <span wire:loading wire:target="addToCart">Agregando...</span>
        </a>
    </div>
    <div class="pro-details-action tw-inline-block">
        @if($product)
            @livewire('product.wishlist-toggle', ['productId' => $product->id, 'mini' => true], key('wishlist-' . $product->id))
        @endif
        <a class="social" title="Social" href="#"><i class="icon-share"></i></a>
        <div class="product-dec-social">
            <a class="facebook" title="Facebook" href="#"><i class="icon-social-facebook"></i></a>
            <a class="twitter" title="Twitter" href="#"><i class="icon-social-twitter"></i></a>
            <a class="instagram" title="Instagram" href="#"><i class="icon-social-instagram"></i></a>
            <a class="pinterest" title="Pinterest" href="#"><i class="icon-social-pinterest"></i></a>
        </div>
    </div>

    {{-- Modal de validación --}}
    <x-dialog-modal wire:model.live="showValidationModal">
        <x-slot name="title">
            {{ __('Selección requerida') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Por favor selecciona un color y una talla antes de añadir el producto al carrito.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showValidationModal')" wire:loading.attr="disabled">
                {{ __('Entendido') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
