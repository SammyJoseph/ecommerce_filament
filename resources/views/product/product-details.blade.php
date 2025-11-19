@extends('layouts.index')
@section('title', $product->name . ' | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('content')
    @include('_partials.product-details.breadcrumb')

    <div class="product-details-area pt-120 pb-115">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="product-details-tab">
                        <div class="product-dec-right pro-dec-big-img-slider">
                            @php
                                $productImages = $product->getMedia('product_images');
                                $variantImages = $product->has_variants ? collect($variantCombinations['colors'])->filter(fn($c) => !empty($c['image'])) : collect();
                            @endphp
                            @if($productImages->isNotEmpty() || $variantImages->isNotEmpty())
                                @foreach($productImages as $image)
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ $image->getUrl() }}">
                                                <img src="{{ $image->getUrl('preview') }}" alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        <a class="easyzoom-pop-up img-popup" href="{{ $image->getUrl() }}"><i class="icon-size-fullscreen"></i></a>
                                    </div>
                                @endforeach
                                @foreach($variantImages as $color)
                                    <div class="easyzoom-style" data-color-target="{{ $color['value'] }}">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ $color['original'] }}">
                                                <img src="{{ $color['image'] }}" alt="{{ $product->name }} - {{ $color['value'] }}">
                                            </a>
                                        </div>
                                        <a class="easyzoom-pop-up img-popup" href="{{ $color['original'] }}"><i class="icon-size-fullscreen"></i></a>
                                    </div>
                                @endforeach
                            @else
                                <div class="easyzoom-style">
                                    <div class="easyzoom easyzoom--overlay">
                                        <a href="{{ asset('assets/images/product-details/b-large-1.jpg') }}">
                                            <img src="{{ asset('assets/images/product-details/large-1.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <a class="easyzoom-pop-up img-popup" href="{{ asset('assets/images/product-details/b-large-1.jpg') }}"><i class="icon-size-fullscreen"></i></a>
                                </div>
                            @endif
                        </div>
                        <div class="product-dec-left product-dec-slider-small-2 product-dec-small-style2">
                            @php
                                $productThumbs = $product->getMedia('product_images');
                                $variantThumbs = $product->has_variants ? collect($variantCombinations['colors'])->filter(fn($c) => !empty($c['thumb'])) : collect();
                            @endphp
                            @if($productThumbs->isNotEmpty() || $variantThumbs->isNotEmpty())
                                @foreach($productThumbs as $image)
                                    <div class="product-dec-small @if ($loop->first) active @endif">
                                        <img src="{{ $image->getUrl('thumb') }}" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                                @foreach($variantThumbs as $color)
                                    <div class="product-dec-small" data-color-target="{{ $color['value'] }}">
                                        <img src="{{ $color['thumb'] }}" alt="{{ $product->name }} - {{ $color['value'] }}">
                                    </div>
                                @endforeach
                            @else
                                <div class="product-dec-small active">
                                    <img src="{{ asset('assets/images/product-details/small-1.jpg') }}" alt="">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="product-details-content pro-details-content-mt-md">
                        <h2>{{ $product->name }}</h2>
                        <div class="product-ratting-review-wrap">
                            <div class="product-ratting-digit-wrap">
                                <div class="product-ratting">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                </div>
                                <div class="product-digit">
                                    <span>5.0</span>
                                </div>
                            </div>
                            <div class="product-review-order">
                                <span>62 Reviews</span>
                                <span>242 orders</span>
                            </div>
                        </div>
                        <p>{!! $product->description !!}</p>
                        <div class="pro-details-price">
                            @if ($product->has_variants)
                                <span class="new-price" id="variant-price"></span>
                                <span class="old-price" id="variant-old-price" style="display: none;"></span>
                            @else
                                @if ($product->sale_price)
                                    <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                @endif
                            @endif
                        </div>
                        @if ($product->has_variants && !empty($variantCombinations['colors']))
                            <div class="pro-details-color-wrap">
                                <span>Color:</span>
                                <div class="pro-details-color-content">
                                    <ul>
                                        @foreach ($variantCombinations['colors'] as $color)
                                            <li><a href="#" data-color="{{ $color['value'] }}" title="{{ $color['value'] }}" @style(['background-color: ' . $color['color_code']])></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if ($product->has_variants && !empty($variantCombinations['sizes']))
                            <div class="pro-details-size">
                                <span>Size:</span>
                                <div class="pro-details-size-content">
                                    <ul>
                                        @foreach ($variantCombinations['sizes'] as $size)
                                            <li><a href="#" data-size="{{ $size['value'] }}">{{ $size['value'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- Quantity Controls --}}
                        <div class="pro-details-quality tw-mb-4" x-data="{ quantity: 1 }" id="product-quantity-container">
                            <span>Quantity:</span>
                            <div class="cart-plus-minus">
                                <div class="dec qtybutton" @click="quantity = Math.max(1, quantity - 1)">-</div>
                                <input class="cart-plus-minus-box" type="text" :value="quantity" readonly id="product-quantity-input">
                                <div class="inc qtybutton" @click="quantity++">+</div>
                            </div>
                        </div>

                        {{-- Category & Tag --}}
                        <div class="product-details-meta">
                            <ul>
                                <li><span>Categories:</span> <a href="#">{{ $product->category->name }}</a></li>
                                <li><span>Tag: </span> <a href="#">Fashion,</a> <a href="#">Mentone</a> , <a href="#">Texas</a></li>
                            </ul>
                        </div>

                        <div class="pro-details-action-wrap">
                            @livewire('product.add-to-cart', ['product' => $product, 'classes' => ''])                        

                            {{-- Share buttons --}}
                            <div class="pro-details-action" bis_skin_checked="1">
                                <a title="Add to Wishlist" href="#"><i class="icon-heart"></i></a>
                                <a title="Add to Compare" href="#"><i class="icon-refresh"></i></a>
                                <a class="social" title="Social" href="#"><i class="icon-share"></i></a>
                                <div class="product-dec-social" bis_skin_checked="1">
                                    <a class="facebook" title="Facebook" href="#"><i class="icon-social-facebook"></i></a>
                                    <a class="twitter" title="Twitter" href="#"><i class="icon-social-twitter"></i></a>
                                    <a class="instagram" title="Instagram" href="#"><i class="icon-social-instagram"></i></a>
                                    <a class="pinterest" title="Pinterest" href="#"><i class="icon-social-pinterest"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('_partials.product-details.product-description')
    @include('_partials.product-details.related-products')
@endsection

@push('css')
    @include('_partials.product-details.custom-css')
@endpush

@if ($product->has_variants)
    @push('scripts')
        @include('_partials.product-details.custom-js')
    @endpush
@endif