<div class="shop-area pt-100 pb-120" x-data="{
        product: {},
        activeImage: '',
        activeThumbIndex: 0,
        updateProductData(product) {
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
    }">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-topbar-wrapper">
                    <div class="shop-topbar-left">
                        <div class="view-mode nav">
                            <a class="active" href="#shop-1" data-bs-toggle="tab"><i class="icon-grid"></i></a>
                            <a href="#shop-2" data-bs-toggle="tab"><i class="icon-menu"></i></a>
                        </div>
                        <p>Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results </p>
                    </div>
                    <div class="product-sorting-wrapper">
                        <div class="product-shorting shorting-style">
                            <label>View :</label>
                            <select wire:model.live="per_page">
                                <option value="6"> 6</option>
                                <option value="12"> 12</option>
                                <option value="24"> 24</option>
                                <option value="48"> 48</option>
                            </select>
                        </div>
                        <div class="product-show shorting-style">
                            <label>Sort by :</label>
                            <select wire:model.live="sort_by">
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
                            <div class="row">
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
                                        'variant_combinations' => $product->has_variants ? $product->getVariantCombinations() : [],
                                    ]);
                                @endphp
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" wire:key="product-grid-{{ $product->id }}">
                                    <div class="single-product-wrap mb-35">
                                        <div class="product-img product-img-zoom mb-15">
                                            <a href="product-details.html">
                                                <img src="{{ $product->getFirstMediaUrl('product_images', 'preview') }}" alt="{{ $product->name }}">
                                            </a>
                                            @if($product->sale_price && $product->sale_price < $product->price)
                                                <span class="pro-badge left bg-red">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                                            @endif
                                            <div class="product-action-2 tooltip-style-2">
                                                <button title="Wishlist" wire:click="toggleWishlist({{ $product->id }})">
                                                    @if (in_array($product->id, $wishlistProductIds))
                                                        <svg class="tw-w-5 tw-text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/></svg>
                                                    @else
                                                        <svg class="tw-w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="m480-173.85-30.31-27.38q-97.92-89.46-162-153.15-64.07-63.7-101.15-112.35-37.08-48.65-51.81-88.04Q120-594.15 120-634q0-76.31 51.85-128.15Q223.69-814 300-814q52.77 0 99 27t81 78.54Q514.77-760 561-787q46.23-27 99-27 76.31 0 128.15 51.85Q840-710.31 840-634q0 39.85-14.73 79.23-14.73 39.39-51.81 88.04-37.08 48.65-100.77 112.35Q609-290.69 510.31-201.23L480-173.85Zm0-54.15q96-86.77 158-148.65 62-61.89 98-107.39t50-80.61q14-35.12 14-69.35 0-60-40-100t-100-40q-47.77 0-88.15 27.27-40.39 27.27-72.31 82.11h-39.08q-32.69-55.61-72.69-82.5Q347.77-774 300-774q-59.23 0-99.62 40Q160-694 160-634q0 34.23 14 69.35 14 35.11 50 80.61t98 107q62 61.5 158 149.04Zm0-273Z"/></svg>
                                                    @endif
                                                </button>
                                                <button title="Quick View" x-on:click="updateProductData({{ $productData }})" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="icon-size-fullscreen icons"></i></button>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap-2 text-center">
                                            <div class="product-rating-wrap">
                                                <div class="product-rating">
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                </div>
                                                <span>(5)</span>
                                            </div>
                                            <h3><a href="product-details.html">{{ $product->name }}</a></h3>
                                            <div class="product-price-2">
                                                @if($product->sale_price && $product->sale_price < $product->price)
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
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                </div>
                                                <span>(5)</span>
                                            </div>
                                            <h3><a href="product-details.html">{{ $product->name }}</a></h3>
                                            <div class="product-price-2">
                                                @if($product->sale_price && $product->sale_price < $product->price)
                                                    <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span>${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="pro-add-to-cart">
                                                @if($product->has_variants)
                                                    <button title="Add to Cart"
                                                        x-on:click="updateProductData({{ $productData }})"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Add To Cart
                                                    </button>
                                                @else
                                                    @livewire('product.add-to-cart', ['product' => $product, 'showIcon' => false], key('cart-' . $product->id))
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
                                    'variant_combinations' => $product->has_variants ? $product->getVariantCombinations() : [],
                                ]);
                            @endphp
                            <div class="shop-list-wrap mb-30" wire:key="{{ $loopKey }}">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-6">
                                        <div class="product-list-img">
                                            <a href="product-details.html">
                                                <img src="{{ $product->getFirstMediaUrl('product_images', 'preview') }}" alt="{{ $product->name }}">
                                            </a>
                                            <div class="product-list-quickview">
                                                <button title="Quick View" x-on:click="updateProductData({{ $productData }})" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="icon-size-fullscreen icons"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-6">
                                        <div class="shop-list-content">
                                            <h3><a href="product-details.html">{{ $product->name }}</a></h3>
                                            <div class="pro-list-price">
                                                @if($product->sale_price && $product->sale_price < $product->price)
                                                    <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="product-list-rating-wrap">
                                                <div class="product-list-rating">
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                    <i class="icon_star"></i>
                                                </div>
                                                <span>(5)</span>
                                            </div>
                                            <p>{{ $product->description }}</p>
                                            <div class="product-list-action">
                                                <button title="Add To Cart"><i class="icon-basket-loaded"></i></button>
                                                <button title="Wishlist" wire:click="toggleWishlist({{ $product->id }})">
                                                    <i class="icon-heart {{ in_array($product->id, $wishlistProductIds) ? 'tw-text-red-500' : '' }}"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    {{ $products->links('livewire.shop-pagination') }}
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
                                    <li>
                                        <a href="#" wire:click.prevent="filterByCategory('{{ $category->slug }}')" class="{{ $category_slug == $category->slug ? '!tw-text-red-500 !tw-flex tw-justify-between tw-items-center' : '' }}">
                                            {{ $category->name }}
                                            @if($category_slug == $category->slug)
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