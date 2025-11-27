<div class="cart-main-area pt-115 pb-120">
    <div class="container">
        <h3 class="cart-page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#">
                    <div class="table-content table-responsive cart-table-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($wishlistItems as $item)
                                    <tr wire:key="wishlist-item-{{ $item->id }}">
                                        <td class="product-thumbnail tw-py-8 tw-px-4">
                                            <a href="{{ route('product.details', $item->product) }}">
                                                <img src="{{ $item->product->getFirstMediaUrl('product_images', 'thumb') }}" alt="{{ $item->product->name }}">
                                            </a>
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route('product.details', $item->product) }}">{{ $item->product->name }}</a>
                                        </td>
                                        <td class="product-price-cart">
                                            @if($item->product->sale_price && $item->product->sale_price < $item->product->price)
                                                <span class="amount">${{ number_format($item->product->sale_price, 2) }}</span>
                                                <del class="text-muted">${{ number_format($item->product->price, 2) }}</del>
                                            @else
                                                <span class="amount">${{ number_format($item->product->price, 2) }}</span>
                                            @endif
                                        </td>
                                        <td class="product-wishlist-cart">
                                            <div class="tw-flex tw-gap-2 tw-justify-center">
                                                @livewire('product.add-to-cart', ['product' => $item->product, 'showIcon' => false], key('cart-' . $item->product->id))
                                                <button type="button" wire:click="removeFromWishlist({{ $item->id }})" class="tw-text-red-500 hover:tw-text-red-700">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">Your wishlist is empty.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>