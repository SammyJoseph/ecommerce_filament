<div class="tw-inline-block">
    @if($mini)
        <a title="Add to wishlist" href="#" wire:click.prevent="toggleWishlist">
            <x-wishlist-icon :active="$isInWishlist" size="tw-w-[20px]" />
        </a>
    @else
        <button class="font-inc" wire:click="toggleWishlist">
            <x-wishlist-icon :active="$isInWishlist" />
            <span>Wishlist</span>
        </button>
    @endif
</div>
