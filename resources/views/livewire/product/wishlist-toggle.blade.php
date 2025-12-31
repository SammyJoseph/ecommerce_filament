<div class="tw-inline-block">
    @if($mini)
        <a title="Agregar a Favoritos" href="#" wire:click.prevent="toggleWishlist">
            <x-wishlist-icon :active="$isInWishlist" size="tw-w-[20px]" />
        </a>
    @else
        <button class="font-inc" wire:click="toggleWishlist">
            <x-wishlist-icon :active="$isInWishlist" />
            <span>Favoritos</span>
        </button>
    @endif
</div>
