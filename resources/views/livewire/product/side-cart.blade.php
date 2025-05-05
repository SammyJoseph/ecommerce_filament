<div class="offCanvas__minicart {{ $isOpen ? 'active' : '' }}" tabindex="-1">
    <div class="minicart__header ">
        <div class="minicart__header--top d-flex justify-content-between align-items-center">
            <h3 class="minicart__title"> Shopping Cart</h3>
            <button class="minicart__close--btn" aria-label="minicart close btn">
                <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg>
            </button>
        </div>
        <p class="minicart__header--desc">The organic foods products are limited</p>
    </div>
    <div class="minicart__product">
        @forelse ($productsInCart as $product)
        <div class="minicart__product--items d-flex">
            <div class="minicart__thumbnail">
                <a href="product-details.html"><img src="{{ $product->options->image }}" alt="{{ $product->name }}"></a>
            </div>
            <div class="minicart__text">
                <h4 class="minicart__subtitle"><a href="product-details.html">{{ $product->name }}</a></h4>
                <span class="color__variant"><b>Color:</b> Beige</span>
                <div class="minicart__price">
                    <span class="current__price">{{ $product->price }}</span>
                    <span class="old__price">$140.00</span>
                </div>
                <div class="minicart__text--footer d-flex align-items-center">
                    <div class="quantity__box minicart__quantity">
                        <button type="button" class="quantity__value decrease" aria-label="quantity value" value="Decrease Value">-</button>
                        <label>
                            <input type="number" class="quantity__number" value="{{ $product->qty }}" />
                        </label>
                        <button type="button" class="quantity__value increase" aria-label="quantity value" value="Increase Value">+</button>
                    </div>
                    <button wire:click="removeFromCart('{{ $product->rowId }}')" class="minicart__product--remove" aria-label="minicart remove btn">Remove</button>
                </div>
            </div>
        </div>
        @empty
        <div class="minicart__product--items d-flex">
            <div class="minicart__text">
                <h4 class="minicart__subtitle"><a href="product-details.html">No products in cart</a></h4>
            </div>
        </div>
        @endforelse
    </div>
    <div class="minicart__amount">
        <div class="minicart__amount_list d-flex justify-content-between">
            <span>Sub Total:</span>
            <span><b>$240.00</b></span>
        </div>
        <div class="minicart__amount_list d-flex justify-content-between">
            <span>Total:</span>
            <span><b>$240.00</b></span>
        </div>
    </div>
    <div class="minicart__conditions text-center">
        <input class="minicart__conditions--input" id="accept" type="checkbox">
        <label class="minicart__conditions--label" for="accept">I agree with the <a class="minicart__conditions--link" href="privacy-policy.html">Privacy And Policy</a></label>
    </div>
    <div class="minicart__button d-flex justify-content-center">
        <a class="primary__btn minicart__button--link" href="{{ route('cart.index') }}">View cart</a>
        <a class="primary__btn minicart__button--link" href="checkout.html">Checkout</a>
    </div>
</div>