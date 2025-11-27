<div>
    @if (Cart::instance('wishlist')->count() > 0)
    <span class="pro-count red">
        {{ Cart::instance('wishlist')->count() }}
    </span>
    @endif
</div>
