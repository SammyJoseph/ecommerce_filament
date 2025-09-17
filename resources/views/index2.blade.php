@extends('layouts.index2')
@section('title', 'Norda - Minimal eCommerce HTML Template')

@section('main-wrapper-attrs')
    x-data="{
        product: {},
        activeImage: '',
        activeThumbIndex: 0,
        updateProductData(product) {
            this.product = { ...product };
            if (product.images && product.images.length > 0) {
                this.activeImage = product.images[0];
                this.activeThumbIndex = 0;
            }
        }
    }"
@endsection

@section('header-extra-classes', 'transparent-bar section-padding-1')
@section('container-class', 'container-fluid')

@section('content')        
        <div class="slider-area bg-gray">
            <div class="hero-slider-active-1 hero-slider-pt-1 nav-style-1 dot-style-1">
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="hero-slider-content-1 hero-slider-content-1-pt-1 slider-animated-1">
                                    <h4 class="animated">New Arrivals</h4>
                                    <h1 class="animated">Leather Simple <br>Backpacks</h1>
                                    <p class="animated">Discover our collection with leather simple backpacks. Less is more never out trend.</p>
                                    <div class="btn-style-1">
                                        <a class="animated btn-1-padding-1" href="product-details.html">Explore Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="hero-slider-img-1 slider-animated-1">
                                    <img class="animated" src="{{ asset('assets2/images/slider/hm-1-slider-1.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="hero-slider-content-1 hero-slider-content-1-pt-1 slider-animated-1">
                                    <h4 class="animated">New Arrivals</h4>
                                    <h1 class="animated">Leather Simple <br>Backpacks</h1>
                                    <p class="animated">Discover our collection with leather simple backpacks. Less is more never out trend.</p>
                                    <div class="btn-style-1">
                                        <a class="animated btn-1-padding-1" href="product-details.html">Explore Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="hero-slider-img-1 slider-animated-1">
                                    <img class="animated" src="{{ asset('assets2/images/slider/hm-1-slider-4.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="service-area">
            <div class="container">
                <div class="service-wrap">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="single-service-wrap mb-30">
                                <div class="service-icon">
                                    <i class="icon-cursor"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Free Shipping</h3>
                                    <span>Orders over $100</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="single-service-wrap mb-30">
                                <div class="service-icon">
                                    <i class="icon-reload"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Free Returns</h3>
                                    <span>Within 30 days</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="single-service-wrap mb-30">
                                <div class="service-icon">
                                    <i class="icon-lock"></i>
                                </div>
                                <div class="service-content">
                                    <h3>100% Secure</h3>
                                    <span>Payment Online</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="single-service-wrap mb-30">
                                <div class="service-icon">
                                    <i class="icon-tag"></i>
                                </div>
                                <div class="service-content">
                                    <h3>Best Price</h3>
                                    <span>Guaranteed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-us-area pt-85">
            <div class="container">
                <div class="border-bottom-1 about-content-pb">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="about-us-logo">
                                <img src="{{ asset('assets2/images/about/logo.png') }}">
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="about-us-content">
                                <h3>Introduce</h3>
                                <p>Norda store is a business concept is to offer fashion and quality at the best price. It has since it was founded in 2022 grown into one of the best WooCommerce Fashion Theme. The content of this site is copyright-protected and is the property of David Moye Creative.</p>
                                <div class="signature">
                                    <h2>David Moye</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-area section-padding-1 pt-115 pb-75">
            <div class="container">
                <div class="section-title-tab-wrap mb-45">
                    <div class="section-title">
                        <h2>Featured Products</h2>
                    </div>
                    <div class="tab-style-1 nav">
                        @foreach ($categories->take(4) as $category)
                        <a class="{{ $loop->first ? 'active' : '' }}" href="#product-{{ $category->id }}" data-bs-toggle="tab">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="tab-content jump">
                    @foreach ($categories as $category)
                    <div id="product-{{ $category->id }}" class="tab-pane {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($category->products->take(8) as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="single-product-wrap mb-35">
                                    <div class="product-img product-img-zoom mb-20">
                                        <a href="product-details.html">
                                            <img src="{{ $product->getFirstMediaUrl('product_images', 'preview') }}" alt="{{ $product->name }}">
                                        </a>
                                        <div class="product-action-wrap">
                                        <div class="product-action-left">
                                            @livewire('product.add-to-cart', ['product' => $product, 'classes' => 'tw-flex tw-items-center'])
                                        </div>
                                            <div class="product-action-right tooltip-style">
                                                <button
                                                    x-on:click="updateProductData({{ json_encode([
                                                        'name' => $product->name,
                                                        'images' => $product->getMedia('product_images')->map(fn($media) => $media->getUrl('preview'))->all(),
                                                        'thumb_images' => $product->getMedia('product_images')->map(fn($media) => $media->getUrl('thumb'))->all(),
                                                        'price' => $product->price,
                                                        'sale_price' => $product->sale_price,
                                                        'description' => $product->description,
                                                    ]) }})"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <i class="icon-size-fullscreen icons"></i><span>Vista Rápida</span>
                                                </button>
                                                <button class="font-inc"><i class="icon-refresh"></i><span>Compare</span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-content-left">
                                            <h4><a href="product-details.html">{{ Str::limit($product->name, 27) }}</a></h4>
                                            <div class="product-price">
                                                @if (!empty($product->sale_price) && $product->sale_price > 0)
                                                    <span class="sale-price">${{ $product->sale_price }}</span>
                                                    <span class="old-price">${{ $product->price }}</span>
                                                @else
                                                    <span class="regular-price">${{ $product->price }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-content-right tooltip-style">
                                            <button class="font-inc"><i class="icon-heart"></i><span>Wishlist</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="banner-area pb-85">
            <div class="container">
                <div class="section-title mb-45">
                    <h2>Our Collections</h2>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <div class="banner-wrap banner-mr-1 mb-30">
                            <div class="banner-img banner-img-zoom">
                                <a href="product-details.html"><img src="{{ asset('assets2/images/banner/banner-1.jpg') }}"></a>
                            </div>
                            <div class="banner-content-1">
                                <h2>Zara Pattern Boxed <br>Underwear</h2>
                                <p>Stretch, fresh-cool help you alway comfortable</p>
                                <div class="btn-style-1">
                                    <a class="animated btn-1-padding-2" href="product-details.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="banner-wrap  banner-ml-1 mb-30">
                            <div class="banner-img banner-img-zoom">
                                <a href="product-details.html"><img src="{{ asset('assets2/images/banner/banner-2.jpg') }}"></a>
                            </div>
                            <div class="banner-content-2">
                                <h2>Basic Color Caps</h2>
                                <p>Minimalist never cool, choose and make the simple great again!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="instagram-area">
            <div class="container">
                <div class="section-title-tag-wrap mb-45">
                    <div class="section-title">
                        <h2>Our Instagram</h2>
                    </div>
                    <div class="instagram-tag">
                        <span>#monkeylover</span>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col">
                        <div class="instagram-item">
                            <a class="instagram-image" href="#">
                                <img src="{{ asset('assets2/images/instagram/1.jpg') }}">
                            </a>
                            <ul class="add-action">
                                <li>
                                    <a href="#">
                                        <i class="icon_plus"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="instagram-item">
                            <a class="instagram-image" href="#">
                                <img src="{{ asset('assets2/images/instagram/2.jpg') }}">
                            </a>
                            <ul class="add-action">
                                <li>
                                    <a href="#">
                                        <i class="icon_plus"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="instagram-item">
                            <a class="instagram-image" href="#">
                                <img src="{{ asset('assets2/images/instagram/3.jpg') }}">
                            </a>
                            <ul class="add-action">
                                <li>
                                    <a href="#">
                                        <i class="icon_plus"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="instagram-item">
                            <a class="instagram-image" href="#">
                                <img src="{{ asset('assets2/images/instagram/4.jpg') }}">
                            </a>
                            <ul class="add-action">
                                <li>
                                    <a href="#">
                                        <i class="icon_plus"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="instagram-item">
                            <a class="instagram-image" href="#">
                                <img src="{{ asset('assets2/images/instagram/5.jpg') }}">
                            </a>
                            <ul class="add-action">
                                <li>
                                    <a href="#">
                                        <i class="icon_plus"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="brand-logo-area pt-100 pb-100">
            <div class="container">
                <div class="brand-logo-wrap brand-logo-mrg">
                    <div class="single-brand-logo mb-10">
                        <img src="{{ asset('assets2/images/brand-logo/brand-logo-1.png') }}">
                    </div>
                    <div class="single-brand-logo mb-10">
                        <img src="{{ asset('assets2/images/brand-logo/brand-logo-2.png') }}">
                    </div>
                    <div class="single-brand-logo mb-10">
                        <img src="{{ asset('assets2/images/brand-logo/brand-logo-3.png') }}">
                    </div>
                    <div class="single-brand-logo mb-10">
                        <img src="{{ asset('assets2/images/brand-logo/brand-logo-4.png') }}">
                    </div>
                    <div class="single-brand-logo mb-10">
                        <img src="{{ asset('assets2/images/brand-logo/brand-logo-5.png') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribe-area bg-gray pt-115 pb-115">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <div class="section-title">
                            <h2>keep connected</h2>
                            <p>Get updates by subscribe our weekly newsletter</p>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div id="mc_embed_signup" class="subscribe-form">
                            <form id="mc-embedded-subscribe-form" class="validate subscribe-form-style" novalidate="" target="_blank" name="mc-embedded-subscribe-form" method="post" action="https://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef">
                                <div id="mc_embed_signup_scroll" class="mc-form">
                                    <input class="email" type="email" required="" placeholder="Enter your email address" name="EMAIL" value="">
                                    <div class="mc-news" aria-hidden="true">
                                        <input type="text" value="" tabindex="-1" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef">
                                    </div>
                                    <div class="clear">
                                        <input id="mc-embedded-subscribe" class="button" type="submit" name="subscribe" value="Subscribe">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-5 col-md-6 col-12 col-sm-12">
                                <div class="tab-content quickview-big-img">
                                    <div class="tab-pane fade show active">
                                        <img :src="activeImage" alt="">
                                    </div>
                                </div>
                                <div class="quickview-wrap mt-15">
                                    <div class="nav nav-style-6 tw-flex tw-flex-nowrap tw-overflow-x-auto tw-gap-2" role="tablist">
                                        <template x-for="(thumb, index) in product.thumb_images" :key="index">
                                            <a href="#" class="nav-link" 
                                                    :class="{ 'active': activeThumbIndex === index }" 
                                                    @click.prevent="activeImage = product.images[index]; activeThumbIndex = index">
                                                <img :src="thumb" alt="product-thumbnail" class="tw-w-24 tw-h-24 tw-object-cover">
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6 col-12 col-sm-12">
                                <div class="product-details-content quickview-content">
                                    <h2 x-text="product.name"></h2>
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
                                            <span>62 Reseñas</span>
                                            <span>242 ordenes</span>
                                        </div>
                                    </div>
                                    <p x-html="product.description" class="tw-line-clamp-2"></p>
                                    <div class="pro-details-price">
                                        <template x-if="product.sale_price && product.sale_price > 0">
                                            <div>
                                                <span class="new-price" x-text="'S/.' + product.sale_price"></span>
                                                <span class="old-price" x-text="'S/.' + product.price"></span>
                                            </div>
                                        </template>
                                        <template x-if="!product.sale_price || product.sale_price <= 0">
                                            <span class="new-price" x-text="'S/.' + product.price"></span>
                                        </template>
                                    </div>
                                    <div class="pro-details-color-wrap">
                                        <span>Color:</span>
                                        <div class="pro-details-color-content">
                                            <ul>
                                                <li><a class="dolly" href="#">dolly</a></li>
                                                <li><a class="white" href="#">white</a></li>
                                                <li><a class="azalea" href="#">azalea</a></li>
                                                <li><a class="peach-orange" href="#">Orange</a></li>
                                                <li><a class="mona-lisa active" href="#">lisa</a></li>
                                                <li><a class="cupid" href="#">cupid</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pro-details-size">
                                        <span>Talla:</span>
                                        <div class="pro-details-size-content">
                                            <ul>
                                                <li><a href="#">XS</a></li>
                                                <li><a href="#">S</a></li>
                                                <li><a href="#">M</a></li>
                                                <li><a href="#">L</a></li>
                                                <li><a href="#">XL</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pro-details-quality">
                                        <span>Cantidad:</span>
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                                        </div>
                                    </div>
                                    <div class="product-details-meta">
                                        <ul>
                                            <li><span>Categorías:</span> <a href="#">Mujer,</a> <a href="#">Vestido,</a> <a href="#">Polo</a></li>
                                            <li><span>Etiqueta: </span> <a href="#">Moda,</a> <a href="#">Mentone</a> , <a href="#">Texas</a></li>
                                        </ul>
                                    </div>
                                    <div class="pro-details-action-wrap">
                                        <div class="pro-details-add-to-cart">
                                            <a title="Add to Cart" href="#">Añadir al carrito </a>
                                        </div>
                                        <div class="pro-details-action">
                                            <a title="Añadir a la lista de deseos" href="#"><i class="icon-heart"></i></a>
                                            <a title="Añadir para comparar" href="#"><i class="icon-refresh"></i></a>
                                            <a class="social" title="Social" href="#"><i class="icon-share"></i></a>
                                            <div class="product-dec-social">
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
            </div>
        </div>
@endsection