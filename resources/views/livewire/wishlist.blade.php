<div>
    <div class="shop-area pt-100 pb-120"
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
                <div class="col-lg-12">
                    <div class="shop-topbar-wrapper">
                        <div class="shop-topbar-left">
                            <div class="view-mode nav">
                                <a class="active" href="#shop-1" data-bs-toggle="tab"><i class="icon-grid"></i></a>
                                <a href="#shop-2" data-bs-toggle="tab"><i class="icon-menu"></i></a>
                            </div>
                            <p>Showing 1 - 20 of 30 results </p>
                        </div>
                        <div class="product-sorting-wrapper">
                            <div class="product-shorting shorting-style">
                                <label>View :</label>
                                <select>
                                    <option value=""> 20</option>
                                    <option value=""> 23</option>
                                    <option value=""> 30</option>
                                </select>
                            </div>
                            <div class="product-show shorting-style">
                                <label>Sort by :</label>
                                <select>
                                    <option value="">Default</option>
                                    <option value=""> Name</option>
                                    <option value=""> price</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="shop-bottom-area">
                        <div class="tab-content jump">
                            <div id="shop-1" class="tab-pane active">
                                <div class="row">
                                    @forelse ($wishlistItems as $item)
                                        @php
                                            $productData = json_encode([
                                                'name' => $item->product->name,
                                                'images' => $item->product->getMedia('product_images')->map(fn($media) => $media->getUrl('preview'))->all(),
                                                'thumb_images' => $item->product->getMedia('product_images')->map(fn($media) => $media->getUrl('thumb'))->all(),
                                                'price' => $item->product->price,
                                                'sale_price' => $item->product->sale_price,
                                                'description' => $item->product->description,
                                                'id' => $item->product->id,
                                                'slug' => $item->product->slug,
                                                'has_variants' => $item->product->has_variants,
                                                'variant_combinations' => $item->product->has_variants ? $item->product->getVariantCombinations() : [],
                                            ]);
                                        @endphp
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="single-product-wrap mb-35">
                                                <div class="product-img product-img-zoom mb-15">
                                                    <a href="product-details.html">
                                                        <img src="{{ $item->image }}" alt="">
                                                    </a>
                                                    @if ($item->product->sale_price && $item->product->sale_price > 0 && $item->product->sale_price < $item->product->price)
                                                        <span class="pro-badge left bg-red">-{{ round((($item->product->price - $item->product->sale_price) / $item->product->price) * 100) }}%</span>
                                                    @endif
                                                    <div class="product-action-2 tooltip-style-2">
                                                        <button title="Remove from Wishlist" wire:click="confirmItemDeletion('{{ $item->product->id }}')">
                                                            <svg class="tw-w-5 tw-text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                                                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z" />
                                                            </svg>
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
                                                    <h3><a href="{{ route('product.details', $item->product->slug) }}">{{ $item->product->name }}</a></h3>
                                                    <div class="product-price-2">
                                                        @if ($item->product->sale_price && $item->product->sale_price > 0)
                                                            <span class="new-price">${{ $item->product->sale_price }}</span>
                                                            <span class="old-price">${{ $item->product->price }}</span>
                                                        @else
                                                            <span>${{ $item->product->price }}</span>
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
                                                    <h3><a href="{{ route('product.details', $item->product->slug) }}">{{ $item->product->name }}</a></h3>
                                                    <div class="product-price-2">
                                                        @if ($item->product->sale_price && $item->product->sale_price > 0)
                                                            <span class="new-price">${{ $item->product->sale_price }}</span>
                                                            <span class="old-price">${{ $item->product->price }}</span>
                                                        @else
                                                            <span>${{ $item->product->price }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="pro-add-to-cart">
                                                        @if ($item->product->has_variants)
                                                            <button title="Add to Cart" x-on:click="updateProductData({{ $productData }})" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                Add To Cart
                                                            </button>
                                                        @else
                                                            @livewire('product.add-to-cart', ['product' => $item->product, 'showIcon' => false], key('cart-wishlist-' . $item->product->id))
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="empty-wishlist">
                                                <img src="assets/images/empty-wishlist.png" alt="">
                                                <h3 class="cart-page-title">Your wishlist is empty</h3>
                                                <p>Start shopping now to add items to your wishlist.</p>
                                                <div class="cart-shiping-update-wrapper">
                                                    <div class="cart-shiping-update">
                                                        <a href="{{ route('shop') }}">Continue Shopping</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div id="shop-2" class="tab-pane">
                                @forelse ($wishlistItems as $item)
                                    @php
                                        $productData = json_encode([
                                            'name' => $item->product->name,
                                            'images' => $item->product->getMedia('product_images')->map(fn($media) => $media->getUrl('preview'))->all(),
                                            'thumb_images' => $item->product->getMedia('product_images')->map(fn($media) => $media->getUrl('thumb'))->all(),
                                            'price' => $item->product->price,
                                            'sale_price' => $item->product->sale_price,
                                            'description' => $item->product->description,
                                            'id' => $item->product->id,
                                            'slug' => $item->product->slug,
                                            'has_variants' => $item->product->has_variants,
                                            'variant_combinations' => $item->product->has_variants ? $item->product->getVariantCombinations() : [],
                                        ]);
                                    @endphp
                                    <div class="shop-list-wrap mb-30">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-6">
                                                <div class="product-list-img">
                                                    <a href="{{ route('product.details', $item->product->slug) }}">
                                                        <img src="{{ $item->image }}" alt="Product Style">
                                                    </a>
                                                    <div class="product-list-quickview">
                                                        <button title="Quick View" x-on:click="updateProductData({{ $productData }})" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="icon-size-fullscreen icons"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-6">
                                                <div class="shop-list-content">
                                                    <h3><a href="{{ route('product.details', $item->product->slug) }}">{{ $item->product->name }}</a></h3>
                                                    <div class="pro-list-price">
                                                        @if ($item->product->sale_price && $item->product->sale_price > 0)
                                                            <span class="new-price">${{ $item->product->sale_price }}</span>
                                                            <span class="old-price">${{ $item->product->price }}</span>
                                                        @else
                                                            <span class="new-price">${{ $item->product->price }}</span>
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
                                                    <p>{!! Str::limit($item->product->description, 200) !!}</p>
                                                    <div class="product-list-action">
                                                        @if ($item->product->has_variants)
                                                            <button title="Add to Cart" x-on:click="updateProductData({{ $productData }})" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                <i class="icon-basket-loaded"></i>
                                                            </button>
                                                        @else
                                                            @livewire('product.add-to-cart', ['product' => $item->product, 'showIcon' => true], key('cart-wishlist-list-' . $item->product->id))
                                                        @endif
                                                        <button title="Remove from Wishlist" wire:click="confirmItemDeletion('{{ $item->product->id }}')">
                                                            <svg class="tw-w-5 tw-text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                                                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="empty-wishlist">
                                            <img src="assets/images/empty-wishlist.png" alt="">
                                            <h3>Your wishlist is empty</h3>
                                            <p>Start shopping now to add items to your wishlist.</p>
                                            <a href="index.html" class="btn btn-primary">Continue Shopping</a>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="pro-pagination-style text-center mt-10">
                            <ul>
                                <li><a class="prev" href="#"><i class="icon-arrow-left"></i></a></li>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a class="next" href="#"><i class="icon-arrow-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('_partials.index.quick-view-modal')
        <!-- Delete Confirmation Modal -->
        <x-confirmation-modal wire:model.live="confirmingItemDeletion">
            <x-slot name="title">
                {{ __('Remove from Wishlist') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to remove this item from your wishlist?') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingItemDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteItem" wire:loading.attr="disabled">
                    {{ __('Remove') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </div>
</div>