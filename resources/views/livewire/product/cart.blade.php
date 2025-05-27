<div class="cart__table">
    @if ($productsInCart->count() > 0)
    <table class="cart__table--inner">
        <thead class="cart__table--header">
            <tr class="cart__table--header__items">
                <th class="cart__table--header__list">Product</th>
                <th class="cart__table--header__list">Price</th>
                <th class="cart__table--header__list">Quantity</th>
                <th class="cart__table--header__list">Total</th>
            </tr>
        </thead>
        <tbody class="cart__table--body">
            @foreach ($productsInCart as $product)
            <tr class="cart__table--body__items" wire:key="cart-item-{{ $product->rowId }}">
                <td class="cart__table--body__list">
                    <div class="cart__product d-flex align-items-center">
                        <button wire:click="removeFromCart('{{ $product->rowId }}')" class="cart__remove--btn" aria-label="search button" type="button"><svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"/></svg></button>                
                        <div class="cart__thumbnail">
                            <a href="product-details.html"><img class="border-radius-5" src="{{ $product->options->image }}" alt="{{ $product->name }}"></a>
                        </div>
                        <div class="cart__content">
                            <h4 class="cart__content--title"><a href="product-details.html">{{ $product->name }}</a></h4>
                            <span class="cart__content--variant">COLOR: Blue</span>
                            <span class="cart__content--variant">WEIGHT: 2 Kg</span>
                        </div>
                    </div>
                </td>
                <td class="cart__table--body__list">
                    <span class="cart__price">{{ $product->price }}</span>
                </td>
                <td class="cart__table--body__list">
                    <div class="quantity__box">
                        @livewire('product.increase-decrease', ['rowId' => $product->rowId, 'quantity' => $product->qty], key($product->rowId))
                        {{-- <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">-</button>
                        <label>
                            <input type="number" class="quantity__number quickview__value--number" value="{{ $product->qty }}" />
                        </label>
                        <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+</button> --}}
                    </div>
                </td>
                <td class="cart__table--body__list">
                    <span class="cart__price end">{{ $product->subtotal }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> 
    <div class="continue__shopping d-flex justify-content-between">
        <a class="continue__shopping--link" href="shop.html">Continue shopping</a>
        <button wire:click="clearCart" class="continue__shopping--clear" type="button">Clear Cart</button>
    </div>   
    @else
    <div class="cart__empty d-flex justify-content-center align-items-center flex-column">
        <img src="{{ asset('assets/img/icon/cart-empty.jpg') }}" alt="empty-cart" class="img-fluid" style="max-width: 300px;">
        <h3 class="cart__empty--title">Your Cart is Empty</h3>
        <p class="cart__empty--desc">Looks like you haven’t added anything to your cart yet.</p>
        <a class="primary__btn cart__empty--btn" href="shop.html">Continue Shopping</a>
    </div>
     @endif
</div>