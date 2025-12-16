<div class="sidebar-cart-active {{ $isOpen ? 'inside' : '' }}">
    <div class="sidebar-cart-all">
        <a class="cart-close" href="#"><i class="icon_close"></i></a>
        <div class="cart-content">
            <h3>Shopping Cart</h3>
            <ul>
                @forelse ($productsInCart as $product)
                    <li class="single-product-cart">
                        <div class="cart-img">
                            <a href="{{ route('product.show', $product->id) }}">
                                <img src="{{ $product->options->image ?? $product->model->getFirstMediaUrl('product_images', 'thumb') ?? asset('assets/images/cart/cart-1.jpg') }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="cart-title">
                            <h4><a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a></h4>
                            <span>{{ $product->qty }} × ${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="cart-delete">
                            <button wire:click="removeFromCart('{{ $product->rowId }}')">×</button>
                        </div>
                    </li>                    
                @empty
                    <li class="text-center py-4">
                        <p>No products in cart</p>
                    </li>
                @endforelse
            </ul>
            <div class="cart-total">
                <h4>Subtotal: <span>${{ $subtotal }}</span></h4>
            </div>
            <div class="cart-checkout-btn">
                <a class="btn-hover cart-btn-style" href="{{ route('cart') }}">view cart</a>
                <a class="no-mrg btn-hover cart-btn-style" href="{{ route('checkout.index') }}">checkout</a>
            </div>
        </div>
    </div>
</div>