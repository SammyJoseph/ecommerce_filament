@extends('layouts.site')
@section('title', 'Norda - Minimal eCommerce HTML Template')

@section('main-wrapper-attrs')
    x-data="{
        modalOpen: false,
        init() {
            this.$nextTick(() => {
                const modalEl = document.getElementById('exampleModal');
                if (modalEl) {
                    modalEl.addEventListener('shown.bs.modal', () => {
                        this.modalOpen = true;
                        history.pushState({ modalOpen: true }, '', window.location.href);
                    });

                    modalEl.addEventListener('hidden.bs.modal', () => {
                        this.modalOpen = false;
                        if (history.state && history.state.modalOpen) {
                            history.back();
                        }
                    });
                }
            });

            window.addEventListener('popstate', (event) => {
                if (this.modalOpen) {
                    const modalEl = document.getElementById('exampleModal');
                    if (modalEl) {
                         const closeBtn = modalEl.querySelector('.btn-close');
                         if (closeBtn) {
                             closeBtn.click();
                         }
                    }
                }
            });
        },
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
            // Populate all possible sizes for this product
            this.allSizes = [];
            if (product.variant_combinations && product.variant_combinations.colors) {
                let sizes = new Set();
                Object.values(product.variant_combinations.colors).forEach(colorData => {
                     if (colorData.available_sizes) {
                         colorData.available_sizes.forEach(s => sizes.add(s));
                     }
                });
                this.allSizes = this.sortSizes(Array.from(sizes));
            }

            // Reset variant selection
            this.selectedColor = null;
            this.minPriceForSelectedColor = product.min_variant_price;
            this.allPricesSameForSelectedColor = false;
            this.selectedSize = null;
            this.quantity = 1;
            this.showColorPrompt = false;
            this.currentPrice = product.price;
            this.currentSalePrice = product.sale_price;
        },
        selectedColor: null,
        minPriceForSelectedColor: 0,
        allPricesSameForSelectedColor: false,
        selectedSize: null,
        quantity: 1,
        availableSizes: [],
        allSizes: [],
        showColorPrompt: false,
        currentPrice: 0,
        currentSalePrice: 0,
        selectColor(color) {
            this.selectedColor = color;
            this.selectedSize = null;
            this.showColorPrompt = false;
            
            // Reset to base product price until size is selected
            this.currentPrice = this.product.price;
            this.currentSalePrice = this.product.sale_price;

            if (this.product.variant_combinations && this.product.variant_combinations.colors[color]) {
                this.availableSizes = this.sortSizes(this.product.variant_combinations.colors[color].available_sizes);
                
                // Calculate minimum price for this color
                let min = Infinity;
                let max = -Infinity;
                let found = false;
                this.availableSizes.forEach(size => {
                    const key = color + '-' + size;
                    const combo = this.product.variant_combinations.combinations[key];
                    if (combo) {
                        let price = parseFloat(combo.price);
                        if (combo.sale_price && parseFloat(combo.sale_price) > 0) {
                            price = parseFloat(combo.sale_price);
                        }
                        if (price < min) min = price;
                        if (price > max) max = price;
                        found = true;
                    }
                });
                this.minPriceForSelectedColor = found ? min : this.product.min_variant_price;
                this.allPricesSameForSelectedColor = found ? (min === max) : false;

                // Update image if color has one
                if (this.product.variant_combinations.colors[color].image) {
                    this.activeImage = this.product.variant_combinations.colors[color].image;
                }
            } else {
                this.availableSizes = [];
                this.minPriceForSelectedColor = this.product.min_variant_price;
            }
        },
        selectSize(size) {
            if (!this.selectedColor) {
                this.showColorPrompt = true;
                return;
            }
            if (!this.availableSizes.includes(size)) return;

            this.selectedSize = size;
            this.showColorPrompt = false;
            if (this.selectedColor && this.product.variant_combinations) {
                const key = this.selectedColor + '-' + size;
                const combination = this.product.variant_combinations.combinations[key];
                if (combination) {
                    this.currentPrice = combination.price;
                    this.currentSalePrice = combination.sale_price;
                }
            }
        },
        sortSizes(sizes) {
             const order = ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '2XL', '3XL', '4XL', '5XL'];
             return sizes.sort((a, b) => {
                 let ia = order.indexOf(a.toUpperCase());
                 let ib = order.indexOf(b.toUpperCase());
                 if (ia === -1 && ib === -1) return a.localeCompare(b); // both unknown
                 if (ia === -1) return 1; // a unknown, put last
                 if (ib === -1) return -1; // b unknown, put last
                 return ia - ib;
             });
        }
    }"
@endsection

@section('header-extra-classes', 'transparent-bar section-padding-1')
@section('container-class', 'container-fluid')

@section('content')        
    @include('_partials.index.slider-area')
    @include('_partials.index.features-area')
    @include('_partials.index.about-us-area')
    
    <div id="featured-products" class="product-area section-padding-1 pt-115 pb-75">
        <div class="container">
            <div class="section-title-tab-wrap mb-45">
                <div class="section-title">
                    <h2>Productos Destacados</h2>
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
                                    'min_variant_price' => $product->min_variant_price,
                                    'variant_combinations' => $product->has_variants ? $product->getVariantCombinations() : [],
                                    'categories' => $product->categories->map(fn($c) => ['name' => $c->name, 'slug' => $c->slug])->values()->all(),
                                    'tags' => $product->tags->map(fn($t) => ['name' => $t->name, 'slug' => $t->slug])->values()->all(),
                                    'average_rating' => $product->reviews_avg_rating ?? 0,
                                    'review_count' => $product->reviews_count ?? 0,
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
                                                    <i class="icon-basket-loaded !-tw-top-px"></i><span>Agregar</span>
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
                                            @if($product->has_variants)
                                                <span class="regular-price"><span class="!tw-text-gray-500">Desde </span>S/{{ number_format($product->min_variant_price, 2, '.', '') }}</span>
                                            @elseif (!empty($product->sale_price) && $product->sale_price > 0)
                                                <span class="sale-price">S/{{ $product->sale_price }}</span>
                                                <span class="old-price">S/{{ $product->price }}</span>
                                            @else
                                                <span class="regular-price">S/{{ $product->price }}</span>
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