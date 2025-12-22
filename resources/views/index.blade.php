@extends('layouts.site')
@section('title', 'Norda - Minimal eCommerce HTML Template')

@section('main-wrapper-attrs')
    x-data="{
        product: {},
        activeImage: '',
        activeThumbIndex: 0,
        updateProductData(product) {
            Livewire.dispatch('update-quick-view-product', { id: product.id });
            this.product = { ...product };
            if (product.images && product.images.length > 0) {
                this.activeImage = product.images[0];
                this.activeThumbIndex = 0;
            }
            // Reset variant selection
            this.selectedColor = null;
            this.selectedSize = null;
            this.quantity = 1;
            this.currentPrice = product.price;
            this.currentSalePrice = product.sale_price;
        },
        selectedColor: null,
        selectedSize: null,
        quantity: 1,
        availableSizes: [],
        currentPrice: 0,
        currentSalePrice: 0,
        selectColor(color) {
            this.selectedColor = color;
            this.selectedSize = null;
            
            // Reset to base product price until size is selected
            this.currentPrice = this.product.price;
            this.currentSalePrice = this.product.sale_price;

            if (this.product.variant_combinations && this.product.variant_combinations.colors[color]) {
                this.availableSizes = this.product.variant_combinations.colors[color].available_sizes;
                // Update image if color has one
                if (this.product.variant_combinations.colors[color].image) {
                    this.activeImage = this.product.variant_combinations.colors[color].image;
                }
            } else {
                this.availableSizes = [];
            }
        },
        selectSize(size) {
            this.selectedSize = size;
            if (this.selectedColor && this.product.variant_combinations) {
                const key = this.selectedColor + '-' + size;
                const combination = this.product.variant_combinations.combinations[key];
                if (combination) {
                    this.currentPrice = combination.price;
                    this.currentSalePrice = combination.sale_price;
                }
            }
        }
    }"
@endsection

@section('header-extra-classes', 'transparent-bar section-padding-1')
@section('container-class', 'container-fluid')

@section('content')        
    @include('_partials.index.slider-area')
    @include('_partials.index.service-area')
    @include('_partials.index.about-us-area')
    
    <div id="featured-products" class="product-area section-padding-1 pt-115 pb-75">
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
                            @php
                                $productData = json_encode([
                                    'name' => $product->name,
                                    'images' => $product->getMedia('product_images')->map(fn($media) => $media->getUrl('preview'))->all(),
                                    'thumb_images' => $product->getMedia('product_images')->map(fn($media) => $media->getUrl('thumb'))->all(),
                                    'price' => $product->price,
                                    'sale_price' => $product->sale_price,
                                    'description' => $product->description,
                                    'id' => $product->id,
                                    'slug' => $product->slug,
                                    'has_variants' => $product->has_variants,
                                    'variant_combinations' => $product->has_variants ? $product->getVariantCombinations() : [],
                                ]);
                            @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="single-product-wrap mb-35" x-data="{ mobileHover: false }" :class="{ 'active-hover': mobileHover }" @click.outside="mobileHover = false">
                                <div class="product-img product-img-zoom mb-20">
                                    <a href="{{ route('product.show', $product) }}" @click="if(window.innerWidth < 1024) { $event.preventDefault(); mobileHover = !mobileHover; }">
                                        <img src="{{ $product->getFirstMediaUrl('product_images', 'preview') }}" alt="{{ $product->name }}">
                                    </a>
                                    <div class="product-action-wrap">
                                        <div class="product-action-left">
                                            @if($product->has_variants)
                                                <button title="Add to Cart" class="tw-flex tw-items-center tw-gap-2"
                                                    x-on:click="updateProductData({{ $productData }})"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <i class="icon-basket-loaded !-tw-top-px"></i><span>Add to cart</span>
                                                </button>
                                            @else
                                                @livewire('product.add-to-cart', ['product' => $product, 'classes' => 'tw-flex tw-items-center'])
                                            @endif
                                        </div>
                                        <div class="product-action-right tooltip-style">
                                            <button
                                                x-on:click="updateProductData({{ $productData }})"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="icon-size-fullscreen icons"></i><span>Vista Rápida</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-content-left">
                                        <h4><a href="{{ route('product.show', $product) }}">{{ Str::limit($product->name, 27) }}</a></h4>
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
                                        @livewire('product.wishlist-toggle', ['productId' => $product->id], key('wishlist-' . $product->id))
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
    
    @include('_partials.index.banner-area')
    @include('_partials.index.instagram-area')
    @include('_partials.index.brand-logo-area')    
    
    @include('_partials.index.quick-view-modal')
@endsection