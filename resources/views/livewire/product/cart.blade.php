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
                        <img class="tw-inline tw-w-full tw-object-cover" src="{{ $product->options->image }}" alt="">
                    </td>
                    <td class="product-name"><a href="{{ route('product.details', $product->options->slug) }}">{{ $product->name }}</a></td>
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
                    <button class="tw-mr-6">Update Cart</button>
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