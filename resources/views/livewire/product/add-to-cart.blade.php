<div class="tw-w-full">
    @if($product && $product->has_variants)
        {{-- Color & Size Selection for Variants --}}
        <div>
            {{-- Hidden inputs to sync with JavaScript --}}
            <input type="hidden" id="livewire-selected-color" value="{{ $selectedColorId }}">
            <input type="hidden" id="livewire-selected-size" value="{{ $selectedSizeId }}">
        </div>
    @endif

    {{-- Quantity Controls --}}
    <div class="pro-details-quality tw-mb-4">
        <span>Quantity:</span>
        <div class="cart-plus-minus">
            <div class="dec qtybutton" wire:click="decrementQuantity">-</div>
            <input class="cart-plus-minus-box" type="text" value="{{ $quantity }}" readonly>
            <div class="inc qtybutton" wire:click="incrementQuantity">+</div>
        </div>
    </div>

    {{-- Category & Tag --}}
    <div class="product-details-meta">
        <ul>
            <li><span>Categories:</span> <a href="#">{{ $product->category->name }}</a></li>
            <li><span>Tag: </span> <a href="#">Fashion,</a> <a href="#">Mentone</a> , <a href="#">Texas</a></li>
        </ul>
    </div>

    <div class="tw-flex">
        {{-- Add to Cart Button --}}
        <div class="pro-details-add-to-cart">
            <button 
                wire:click="addToCart" 
                wire:loading.attr="disabled"
                class="{{ $classes }} tw-relative tw-inline-flex tw-items-center tw-justify-center tw-gap-2 tw-transition-all tw-duration-200"
                id="livewire-add-to-cart-btn"
            >
                <i class="icon-basket-loaded tw--mt-2" wire:loading.remove wire:target="addToCart"></i>
                <div wire:loading wire:target="addToCart" class="tw-inline-block tw-mr-2.5 tw--mt-0.5">
                    <svg class="tw-animate-spin tw-h-5 tw-w-5 tw-text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <span wire:loading.remove wire:target="addToCart">Add to cart</span>
                <span wire:loading wire:target="addToCart">Adding...</span>
            </button>
        </div>

        {{-- Share buttons --}}
        <div class="pro-details-action">
            <a title="Add to Wishlist" href="#"><i class="icon-heart"></i></a>
            <a title="Add to Compare" href="#"><i class="icon-refresh"></i></a>
            <a class="social" title="Social" href="#"><i class="icon-share"></i></a>
            <div class="product-dec-social">
                <a class="facebook" title="Facebook" href="#"><i class="icon-social-facebook"></i></a>
                <a class="twitter" title="Twitter" href="#"><i class="icon-social-twitter"></i></a>
                <a class="instagram" title="Instagram" href="#"><i class="icon-social-instagram"></i></a>
                <a class="pinterest" title="Pinterest" href="#"><i class="icon-social-pinterest"></i></a>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    {{-- @if (session()->has('success'))
        <div class="tw-mt-4 tw-p-3 tw-bg-green-100 tw-border tw-border-green-400 tw-text-green-700 tw-rounded">
            {{ session('success') }}
        </div>
    @endif --}}

    @if (session()->has('error'))
        <div class="tw-mt-4 tw-p-3 tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-rounded">
            {{ session('error') }}
        </div>
    @endif
</div>

@if($product && $product->has_variants)
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sync JavaScript selections with Livewire
            const $colorSwatches = $('.pro-details-color-content a');
            const $sizeSwatches = $('.pro-details-size-content a');
            const $livewireColorInput = $('#livewire-selected-color');
            const $livewireSizeInput = $('#livewire-selected-size');

            // When color is clicked in JavaScript, update Livewire
            $colorSwatches.on('click', function(e) {
                const colorValue = $(this).data('color');
                @this.call('selectColor', colorValue);
            });

            // When size is clicked in JavaScript, update Livewire
            $sizeSwatches.on('click', function(e) {
                const sizeValue = $(this).data('size');
                @this.call('selectSize', sizeValue);
            });

            // Sync Livewire state with Add to Cart button disable state
            Livewire.on('cart-updated', function() {
                // Flash message will be shown by Livewire
            });
        });
    </script>
    @endpush
@endif