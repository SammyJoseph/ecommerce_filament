<div>
    @if (Cart::instance('shopping')->count() > 0)
    <span class="pro-count black">
        {{ Cart::instance('shopping')->count() }}
    </span>
    @endif
</div>
