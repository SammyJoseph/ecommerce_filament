<div>
    @if (Cart::instance('shopping')->count() > 0)
    <span class="pro-count red">
        {{ Cart::instance('shopping')->count() }}
    </span>
    @endif
</div>
