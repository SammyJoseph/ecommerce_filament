<div class="shop-area tw-pt-0 sm:tw-pt-12 pb-120"
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
    }">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-topbar-wrapper tw-flex tw-space-x-2 tw-py-4 md:tw-py-4">
                    <div class="shop-topbar-left tw-flex tw-items-center md:tw-block">
                        <div class="view-mode nav tw-flex-nowrap">
                            <a class="active" href="#shop-1" data-bs-toggle="tab"><i class="icon-grid"></i></a>
                            <a href="#shop-2" data-bs-toggle="tab"><i class="icon-menu"></i></a>
                        </div>
                        <p class="tw-mb-0 tw-whitespace-nowrap !tw-hidden sm:!tw-inline-block"><span class="tw-hidden md:tw-inline-block tw-mr-1">Showing</span>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}<span class="tw-hidden md:tw-inline-block tw-ml-1">results</span></p>
                    </div>
                    <div class="product-sorting-wrapper !tw-flex tw-justify-end tw-items-center tw-gap-2">
                        <div class="product-shorting shorting-style !tw-my-0">
                            <label class="tw-hidden md:tw-inline-block">View :</label>
                            <select class="!tw-w-20" wire:model.live="per_page">
                                <option value="6"> 6</option>
                                <option value="12"> 12</option>
                                <option value="24"> 24</option>
                                <option value="48"> 48</option>
                            </select>
                        </div>
                        <div class="product-show shorting-style !tw-my-0">
                            <label class="tw-hidden md:tw-inline-block">Sort by :</label>
                            <select class="!tw-w-24" wire:model.live="sort_by">
                                <option value="">Default</option>
                                <option value="price_low">Lowest Price</option>
                                <option value="price_high">Highest Price</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="shop-bottom-area">
                    <div class="tab-content jump tw-relative">
                        <div wire:loading.flex wire:target="per_page,sort_by,search,filterByCategory,min_price,max_price,on_sale,is_new,gotoPage,previousPage,nextPage" class="tw-absolute tw-inset-0 tw-justify-center tw-items-center tw-bg-white/75 tw-z-50">
                            <div class="tw-animate-spin tw-rounded-full tw-h-12 tw-w-12 tw-border-4 tw-border-solid tw-border-gray-300 tw-border-t-red-600"></div>
                        </div>
                        <div id="shop-1" class="tab-pane active">
                            <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 tw-gap-4 md:tw-gap-6">
                                @foreach ($products as $product)
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
                                <div wire:key="product-grid-{{ $product->id }}">
                                    <div class="single-product-wrap mb-35" x-data="{ mobileHover: false }" :class="{ 'active-hover': mobileHover }" @click.outside="mobileHover = false">
                                        <div class="product-img product-img-zoom mb-15">
                                            <a href="{{ route('product.show', $product->slug) }}" @click="if(window.innerWidth < 1024) { $event.preventDefault(); mobileHover = !mobileHover; }">
                                                <img src="{{ $product->getFirstMediaUrl('product_images', 'preview') }}" alt="{{ $product->name }}">
                                            </a>
                                            @if($product->sale_price && $product->sale_price < $product->price)
                                                <span class="pro-badge left bg-red">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                                            @endif
                                            <div class="product-action-2 tooltip-style-2">
                                                <button title="Wishlist" wire:click="toggleWishlist({{ $product->id }})">
                                                    <x-wishlist-icon :active="in_array($product->id, $wishlistProductIds)" />
                                                </button>
                                                <button title="Quick View" x-on:click="updateProductData({{ $productData }})" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="icon-size-fullscreen icons"></i></button>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap-2 text-center">
                                            <div class="product-rating-wrap">
                                                <div class="product-rating">
                                                    @php
                                                        $avgRating = $product->reviews_avg_rating ?? 0;
                                                        $reviewCount = $product->reviews_count ?? 0;
                                                        $fullStars = floor($avgRating);
                                                        $hasHalf = ($avgRating - $fullStars) >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($hasHalf ? 1 : 0);
                                                    @endphp
                                                    @if($reviewCount > 0)
                                                        @for($i = 0; $i < $fullStars; $i++)<i class="icon_star"></i>@endfor
                                                        @if($hasHalf)<i class="icon_star-half_alt"></i>@endif
                                                        @for($i = 0; $i < $emptyStars; $i++)<i class="icon_star_alt" style="color: #ccc;"></i>@endfor
                                                    @else
                                                        @for($i = 0; $i < 5; $i++)<i class="icon_star" style="color: #ccc;"></i>@endfor
                                                    @endif
                                                </div>
                                                @if($reviewCount > 0)
                                                    <span>({{ number_format($avgRating, 1) }})</span>
                                                @endif
                                            </div>
                                            <h3><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                            <div class="product-price-2">
                                                @if($product->has_variants)
                                                    <span>Desde ${{ number_format($product->min_variant_price, 2) }}</span>
                                                @elseif($product->sale_price && $product->sale_price < $product->price)
                                                    <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span>${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-content-wrap-2 product-content-position text-center">
                                            <div class="product-rating-wrap">
                                                <div class="product-rating">
                                                    @if($reviewCount > 0)
                                                        @for($i = 0; $i < $fullStars; $i++)<i class="icon_star"></i>@endfor
                                                        @if($hasHalf)<i class="icon_star-half_alt"></i>@endif
                                                        @for($i = 0; $i < $emptyStars; $i++)<i class="icon_star_alt" style="color: #ccc;"></i>@endfor
                                                    @else
                                                        @for($i = 0; $i < 5; $i++)<i class="icon_star" style="color: #ccc;"></i>@endfor
                                                    @endif
                                                </div>
                                                @if($reviewCount > 0)
                                                    <span>({{ number_format($avgRating, 1) }})</span>
                                                @endif
                                            </div>
                                            <h3><a href="{{ route('product.show', $product->slug) }}" class="tw-block tw-truncate">{{ $product->name }}</a></h3>
                                            <div class="product-price-2">
                                                @if($product->has_variants)
                                                    <span>Desde ${{ number_format($product->min_variant_price, 2) }}</span>
                                                @elseif($product->sale_price && $product->sale_price < $product->price)
                                                    <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span>${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="pro-add-to-cart">
                                                @if($product->has_variants)
                                                    <button title="Add to Cart" class="!tw-px-4 sm:!tw-px-7"
                                                        x-on:click="updateProductData({{ $productData }})"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Add To Cart
                                                    </button>
                                                @else
                                                    @livewire('product.add-to-cart', ['product' => $product, 'divClasses' => 'tw-justify-center', 'showIcon' => false], key('cart-' . $product->id))
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="shop-2" class="tab-pane">
                            @foreach ($products as $product)
                            @php
                                $loopKey = 'product-list-' . $product->id;
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
                            <div class="shop-list-wrap mb-30" wire:key="{{ $loopKey }}">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-6">
                                        <div class="product-list-img">
                                            <a href="{{ route('product.show', $product->slug) }}">
                                                <img src="{{ $product->getFirstMediaUrl('product_images', 'preview') }}" alt="{{ $product->name }}">
                                            </a>
                                            <div class="product-list-quickview">
                                                <button title="Quick View" x-on:click="updateProductData({{ $productData }})" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="icon-size-fullscreen icons"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-6">
                                        <div class="shop-list-content">
                                            <h3><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                            <div class="pro-list-price">
                                                @if($product->has_variants)
                                                    <span class="new-price">Desde ${{ number_format($product->min_variant_price, 2) }}</span>
                                                @elseif($product->sale_price && $product->sale_price < $product->price)
                                                    <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="product-list-rating-wrap">
                                                <div class="product-list-rating">
                                                    @php
                                                        $avgRating = $product->reviews_avg_rating ?? 0;
                                                        $reviewCount = $product->reviews_count ?? 0;
                                                        $fullStars = floor($avgRating);
                                                        $hasHalf = ($avgRating - $fullStars) >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($hasHalf ? 1 : 0);
                                                    @endphp
                                                    @if($reviewCount > 0)
                                                        @for($i = 0; $i < $fullStars; $i++)<i class="icon_star"></i>@endfor
                                                        @if($hasHalf)<i class="icon_star-half_alt"></i>@endif
                                                        @for($i = 0; $i < $emptyStars; $i++)<i class="icon_star_alt" style="color: #ccc;"></i>@endfor
                                                    @else
                                                        @for($i = 0; $i < 5; $i++)<i class="icon_star" style="color: #ccc;"></i>@endfor
                                                    @endif
                                                </div>
                                                @if($reviewCount > 0)
                                                    <span>({{ number_format($avgRating, 1) }})</span>
                                                @endif
                                            </div>
                                            <p>{{ $product->description }}</p>
                                            <div class="product-list-action">
                                                <button title="Add To Cart"><i class="icon-basket-loaded"></i></button>
                                                <button title="Wishlist" wire:click="toggleWishlist({{ $product->id }})">
                                                    <x-wishlist-icon :active="in_array($product->id, $wishlistProductIds)" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    {{ $products->links('livewire.pagination') }}
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sidebar-wrapper sidebar-wrapper-mrg-right">
                    <div class="sidebar-widget mb-40">
                        <h4 class="sidebar-widget-title">Search </h4>
                        <div class="sidebar-search">
                            <form class="sidebar-search-form" wire:submit.prevent>
                                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search here...">
                                @if(!empty($search))
                                    <button type="button" wire:click="clearSearch">
                                        <i class="icon-close"></i>
                                    </button>
                                @else
                                    <button type="submit">
                                        <i class="icon-magnifier"></i>
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="sidebar-widget shop-sidebar-border mb-35 pt-40">
                        <h4 class="sidebar-widget-title">Categories </h4>
                        <div class="shop-catigory">
                            <ul>
                                @foreach($categories as $category)
                                    @php
                                        $selected_slugs = $category_slugs ? explode(',', $category_slugs) : [];
                                        $isActive = in_array($category->slug, $selected_slugs);
                                    @endphp
                                    <li>
                                        <a href="#" wire:click.prevent="filterByCategory('{{ $category->slug }}')" class="{{ $isActive ? '!tw-text-red-500 !tw-flex tw-justify-between tw-items-center' : '' }}">
                                            <span>{{ $category->name }} <span class="tw-text-gray-500 tw-text-xs">{{ $category->products_count }}</span></span>
                                            @if($isActive)
                                                <i class="icon-close"></i>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget shop-sidebar-border mb-40 pt-40">
                        <h4 class="sidebar-widget-title">Price Filter </h4>
                        <div class="price-filter">
                            <span>Range:  ${{ number_format($min_price, 2) }} - {{ number_format($max_price, 2) }} </span>
                            <div id="shop-slider-range" wire:ignore></div>
                            <div class="price-slider-amount">
                                <div class="label-input">
                                    <input type="text" id="shop-amount" name="price" placeholder="Add Your Price" />
                                </div>
                                <button type="button">Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-widget shop-sidebar-border mb-40 pt-40">
                        <h4 class="sidebar-widget-title">Refine By </h4>
                        <div class="sidebar-widget-list">
                            <ul>
                                <li>
                                    <div class="sidebar-widget-list-left">
                                        <input type="checkbox" wire:model.live="on_sale"> 
                                        <a href="#" wire:click.prevent="$toggle('on_sale')">On Sale <span>{{ $on_sale_count }}</span> </a>
                                        <span class="checkmark"></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="sidebar-widget-list-left">
                                        <input type="checkbox" wire:model.live="is_new"> 
                                        <a href="#" wire:click.prevent="$toggle('is_new')">New <span>{{ $is_new_count }}</span></a>
                                        <span class="checkmark"></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget shop-sidebar-border pt-40">
                        <h4 class="sidebar-widget-title">Popular Tags</h4>
                        <div class="tag-wrap sidebar-widget-tag">
                            <a href="#">Clothing</a>
                            <a href="#">Accessories</a>
                            <a href="#">For Men</a>
                            <a href="#">Women</a>
                            <a href="#">Fashion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('_partials.index.quick-view-modal')
</div>

@script
<script>
    Livewire.hook('component.init', ({ component, cleanup }) => {
        const slider = $('#shop-slider-range');
        const amount = $('#shop-amount');
        
        if (slider.length) {
            // Check if slider is already initialized and destroy it to reset options
            if (slider.hasClass('ui-slider') || slider.hasClass('ui-widget')) {
                try {
                    slider.slider('destroy');
                } catch (e) {
                    console.log('Slider not initialized yet');
                }
            }

            // Initialize slider with Livewire values
            slider.slider({
                range: true,
                min: 0,
                max: {{ $price_range_max }},
                values: [{{ $min_price }}, {{ $max_price }}],
                slide: function(event, ui) {
                    // Update visual input while dragging
                    amount.val("$" + ui.values[0] + " - $" + ui.values[1]);
                },
                stop: function(event, ui) {
                    // Update Livewire property when drag stops to avoid too many requests
                    $wire.set('min_price', ui.values[0]);
                    $wire.set('max_price', ui.values[1]);
                }
            });
            
            // Set initial value for the input
            amount.val("$" + {{ $min_price }} + " - $" + {{ $max_price }});
        }

        // View Mode Persistence
        const viewKey = 'shop_view_mode';
        
        const restoreView = () => {
            const savedView = localStorage.getItem(viewKey);
            if (savedView === '#shop-2') {
                $('.view-mode a[href="#shop-1"]').removeClass('active');
                $('#shop-1').removeClass('active');
                
                $('.view-mode a[href="#shop-2"]').addClass('active');
                $('#shop-2').addClass('active');
            }
        };

        // Restore on init
        restoreView();

        // Save on tab change
        $(document).on('shown.bs.tab', '.view-mode a[data-bs-toggle="tab"]', function (e) {
            localStorage.setItem(viewKey, $(e.target).attr('href'));
        });

        // Restore after Livewire updates
        Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
            succeed(({ snapshot, effect }) => {
                setTimeout(restoreView, 10);
            });
        });

        cleanup(() => {
            $(document).off('shown.bs.tab', '.view-mode a[data-bs-toggle="tab"]');
        });
    });
</script>
@endscript