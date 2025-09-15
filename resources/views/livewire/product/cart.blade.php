{{-- <div class="cart__table">
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
                        <button wire:click="removeFromCart('{{ $product->rowId }}')" wire:loading.attr="disabled" wire:target="removeFromCart('{{ $product->rowId }}')" class="cart__remove--btn" aria-label="search button" type="button">
                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px" wire:loading.remove wire:target="removeFromCart('{{ $product->rowId }}')"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"/></svg>
                            <div wire:loading wire:target="removeFromCart('{{ $product->rowId }}')" class="tw-inline-block tw-ml-1">
                                <svg class="tw-animate-spin tw-h-3 tw-w-3 tw-text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </button>
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
</div> --}}
<div>
    <div class="table-content table-responsive cart-table-content">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productsInCart as $product)
                <tr wire:key="cart-item-{{ $product->rowId }}">
                    <td class="product-thumbnail tw-p-6">
                        <a href="#"><img class="tw-inline" src="{{ $product->options->image }}" alt=""></a>
                    </td>
                    <td class="product-name"><a href="#">{{ $product->name }}</a></td>
                    <td class="product-price-cart"><span class="amount">${{ number_format($product->price, 2) }}</span></td>
                    <td class="product-quantity pro-details-quality">
                        <div class="cart-plus-minus">
                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="{{ $product->qty }}">
                        </div>
                    </td>
                    <td class="product-subtotal">${{ number_format($product->subtotal, 2) }}</td>
                    <td class="product-remove">
                        <button wire:click="removeFromCart('{{ $product->rowId }}')" wire:loading.attr="disabled" wire:target="removeFromCart('{{ $product->rowId }}')">
                            <i class="icon_close" wire:loading.remove wire:target="removeFromCart('{{ $product->rowId }}')"></i>
                            <div wire:loading wire:target="removeFromCart('{{ $product->rowId }}')" class="tw-inline-block">
                                <svg class="tw-animate-spin tw-h-3 tw-w-3 tw-text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="tw-text-center tw-py-10">
                        Your cart is empty.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="cart-shiping-update-wrapper">
                <div class="cart-shiping-update">
                    <a href="#">Continue Shopping</a>
                </div>
                <div class="cart-clear">
                    <button>Update Cart</button>
                    <button wire:click="clearCart" type="button">
                        <span>Clear Cart</span>
                        <div wire:loading wire:target="clearCart" class="tw-inline-block tw-ml-1">
                            <svg class="tw-animate-spin tw-h-3 tw-w-3 tw-text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>