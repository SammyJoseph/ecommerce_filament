@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<div class="related-product pb-115">
    <div class="container">
        <div class="section-title mb-45 text-center">
            <h2>Related Product</h2>
        </div>
        <div class="related-product-active">
            @foreach($relatedProducts as $relatedProduct)
            <div class="product-plr-1">
                <div class="single-product-wrap">
                    <div class="product-img product-img-zoom mb-15">
                        <a href="{{ route('product.details', $relatedProduct->slug) }}">
                            @if($relatedProduct->getFirstMediaUrl('product_images'))
                                <img src="{{ $relatedProduct->getFirstMediaUrl('product_images', 'preview') }}" alt="{{ $relatedProduct->name }}">
                            @else
                                <img src="{{ asset('assets/images/product/product-13.jpg') }}" alt="{{ $relatedProduct->name }}">
                            @endif
                        </a>
                        @if($relatedProduct->sale_price)
                            @php
                                $discount = round((($relatedProduct->price - $relatedProduct->sale_price) / $relatedProduct->price) * 100);
                            @endphp
                            <span class="pro-badge left bg-red">-{{ $discount }}%</span>
                        @endif
                        <div class="product-action-2 tooltip-style-2">
                            <button title="Wishlist"><i class="icon-heart"></i></button>
                            <button title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="icon-size-fullscreen icons"></i></button>
                            <button title="Compare"><i class="icon-refresh"></i></button>
                        </div>
                    </div>
                    <div class="product-content-wrap-2 text-center">
                        <div class="product-rating-wrap">
                            <div class="product-rating">
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star gray"></i>
                            </div>
                            <span>(2)</span>
                        </div>
                        <h3><a href="{{ route('product.details', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a></h3>
                        <div class="product-price-2">
                            @if($relatedProduct->sale_price)
                                <span class="new-price">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                                <span class="old-price">${{ number_format($relatedProduct->price, 2) }}</span>
                            @else
                                <span>${{ number_format($relatedProduct->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="product-content-wrap-2 product-content-position text-center">
                        <div class="product-rating-wrap">
                            <div class="product-rating">
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star gray"></i>
                            </div>
                            <span>(2)</span>
                        </div>
                        <h3><a href="{{ route('product.details', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a></h3>
                        <div class="product-price-2">
                            @if($relatedProduct->sale_price)
                                <span class="new-price">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                                <span class="old-price">${{ number_format($relatedProduct->price, 2) }}</span>
                            @else
                                <span>${{ number_format($relatedProduct->price, 2) }}</span>
                            @endif
                        </div>
                        <div class="pro-add-to-cart">
                            <button title="Add to Cart">Add To Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif