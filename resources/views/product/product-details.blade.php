@extends('layouts.index')
@section('title', $product->name . ' | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('content')
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('index') }}">Home</a>
                    </li>
                    <li>
                        <a href="#">{{ $product->category->name }}</a>
                    </li>
                    <li class="active">{{ $product->name }}</li>
                </ul>
            </div>
        </div>
    </div>
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
                                        <a href="{{ asset('assets2/images/product-details/b-large-1.jpg') }}">
                                            <img src="{{ asset('assets2/images/product-details/large-1.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <a class="easyzoom-pop-up img-popup" href="{{ asset('assets2/images/product-details/b-large-1.jpg') }}"><i class="icon-size-fullscreen"></i></a>
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
                                    <img src="{{ asset('assets2/images/product-details/small-1.jpg') }}" alt="">
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
                                            <li><a href="#" data-color="{{ $color['value'] }}" title="{{ $color['value'] }}" style="background-color: {{ $color['color_code'] }};"></a></li>
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
                        <div class="pro-details-quality">
                            <span>Quantity:</span>
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                            </div>
                        </div>
                        <div class="product-details-meta">
                            <ul>
                                <li><span>Categories:</span> <a href="#">{{ $product->category->name }}</a></li>
                                <li><span>Tag: </span> <a href="#">Fashion,</a> <a href="#">Mentone</a> , <a href="#">Texas</a></li>
                            </ul>
                        </div>
                        <div class="pro-details-action-wrap">
                            <div class="pro-details-add-to-cart">
                                <a title="Add to Cart" href="#">Add To Cart </a>
                            </div>
                            <div class="pro-details-action">
                                <a title="Add to Wishlist" href="#"><i class="icon-heart"></i></a>
                                <a title="Add to Compare" href="#"><i class="icon-refresh"></i></a>
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

    {{-- @include('_partials.index.temp-product-details') --}}
@endsection

@push('css')
    <style>
        .pro-details-color-content ul li.disabled,
        .pro-details-size-content ul li.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pro-details-size-content ul li.disabled a {
            position: relative;
            display: inline-block;
        }

        .pro-details-size-content ul li.disabled a::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: #999;
            transform: rotate(-20deg);
        }

        .pro-details-add-to-cart a.disabled {
            background-color: #a8a8a8;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
@endpush

@if ($product->has_variants)
    @push('scripts')
        <script>
            $(document).ready(function() {
                const combinations = @json($variantCombinations['combinations']);
                const colors = @json($variantCombinations['colors']);
                const sizes = @json($variantCombinations['sizes']);
                const productMediaCount = {{ $productImages->count() }};

                let selectedColor = null;
                let selectedSize = null;

                const $colorSwatches = $('.pro-details-color-content a');
                const $sizeSwatches = $('.pro-details-size-content a');
                const $variantPrice = $('#variant-price');
                const $variantOldPrice = $('#variant-old-price');
                const $addToCartBtn = $('.pro-details-add-to-cart a');

                function updateUI() {
                    // First, enable all options
                    $sizeSwatches.parent().removeClass('disabled');
                    $colorSwatches.parent().removeClass('disabled');

                    // Update size availability based on selected color
                    if (selectedColor && colors[selectedColor]) {
                        const availableSizes = colors[selectedColor].available_sizes;
                        $sizeSwatches.each(function() {
                            const size = $(this).data('size').toString();
                            if (!availableSizes.map(s => s.toString()).includes(size)) {
                                $(this).parent().addClass('disabled');
                                if (selectedSize === size) {
                                    selectedSize = null;
                                    $sizeSwatches.removeClass('active');
                                }
                            }
                        });
                    }

                    // Update color availability based on selected size
                    if (selectedSize && sizes[selectedSize]) {
                        const availableColors = sizes[selectedSize].available_colors;
                        $colorSwatches.each(function() {
                            const color = $(this).data('color').toString();
                            if (!availableColors.map(c => c.toString()).includes(color)) {
                                $(this).parent().addClass('disabled');
                                if (selectedColor === color) {
                                    selectedColor = null;
                                    $colorSwatches.removeClass('active');
                                }
                            }
                        });
                    }

                    // Update price and add to cart button
                    let displayPrice = '';
                    let displayOldPrice = '';
                    let isValidCombo = false;
                    let currentCombination = null;

                    if (selectedColor) {
                        let comboKey;
                        let combination;

                        if (selectedSize) {
                            // Use specific combination if size selected
                            comboKey = selectedColor + '-' + selectedSize;
                            combination = combinations[comboKey];
                            isValidCombo = !!combination;
                        } else {
                            // Use first available size for color if no size selected
                            if (colors[selectedColor] && colors[selectedColor].available_sizes && colors[selectedColor].available_sizes.length > 0) {
                                const firstSize = colors[selectedColor].available_sizes[0].toString();
                                comboKey = selectedColor + '-' + firstSize;
                                combination = combinations[comboKey];
                                isValidCombo = !!combination;
                            }
                        }

                        if (isValidCombo && combination) {
                            currentCombination = combination;
                            if (combination.sale_price && parseFloat(combination.sale_price) < parseFloat(combination.price)) {
                                displayPrice = '$' + parseFloat(combination.sale_price).toFixed(2);
                                displayOldPrice = '$' + parseFloat(combination.price).toFixed(2);
                                $variantOldPrice.text(displayOldPrice).show();
                            } else {
                                displayPrice = '$' + parseFloat(combination.price).toFixed(2);
                                $variantOldPrice.hide();
                            }
                            $variantPrice.text(displayPrice);
                        } else {
                            $variantPrice.text('');
                            $variantOldPrice.hide();
                        }
                    } else {
                        $variantPrice.text('');
                        $variantOldPrice.hide();
                    }

                    // Add to cart button only enabled if both selected and valid
                    if (selectedColor && selectedSize && isValidCombo && currentCombination) {
                        if (currentCombination.stock > 0) {
                            $addToCartBtn.text('Add To Cart').removeClass('disabled');
                        } else {
                            $addToCartBtn.text('Out of Stock').addClass('disabled');
                        }
                    } else {
                        $addToCartBtn.text(selectedColor ? 'Select Size' : 'Select Options').addClass('disabled');
                    }
                }

                function goToSlide(slider, index) {
                    if (slider.hasClass('slick-initialized')) {
                        slider.slick('slickGoTo', index, false);
                    } else {
                        setTimeout(() => goToSlide(slider, index), 50);
                    }
                }

                function updateImage() {
                    if (!selectedColor) return;

                    const $mainSlider = $('.pro-dec-big-img-slider');

                    // Calculate main image index
                    let variantImageIndex = -1;
                    let i = 0;
                    for (let key in colors) {
                        if (colors[key].image && colors[key].image.trim() !== '') {
                            if (key === selectedColor) {
                                variantImageIndex = i;
                                break;
                            }
                            i++;
                        }
                    }
                    if (variantImageIndex !== -1 && $mainSlider.length > 0) {
                        const slideIndex = productMediaCount + variantImageIndex;
                        goToSlide($mainSlider, slideIndex);
                    }

                    // Update thumbnail
                    const $thumbSlider = $('.product-dec-left');

                    let variantThumbIndex = -1;
                    let j = 0;
                    for (let key in colors) {
                        if (colors[key].thumb && colors[key].thumb.trim() !== '') {
                            if (key === selectedColor) {
                                variantThumbIndex = j;
                                break;
                            }
                            j++;
                        }
                    }
                    if (variantThumbIndex !== -1 && $thumbSlider.length > 0) {
                        const thumbSlideIndex = productMediaCount + variantThumbIndex;
                        goToSlide($thumbSlider, thumbSlideIndex);
                    }
                }


                $sizeSwatches.on('click', function(e) {
                    e.preventDefault();
                    if ($(this).parent().hasClass('disabled') || $(this).hasClass('active')) return;

                    selectedSize = $(this).data('size').toString();
                    $sizeSwatches.removeClass('active');
                    $(this).addClass('active');
                    updateUI();
                });

                $colorSwatches.on('click', function(e) {
                    e.preventDefault();
                    if ($(this).parent().hasClass('disabled')) return;

                    selectedColor = $(this).data('color').toString();
                    $colorSwatches.removeClass('active');
                    $(this).addClass('active');
                    updateImage();
                    updateUI();
                });

                // Auto-select first color on load for price, but no image change
                if ($colorSwatches.length > 0) {
                    const firstColor = $colorSwatches.first();
                    selectedColor = firstColor.data('color').toString();
                    firstColor.addClass('active');
                    updateUI(); // Update price, but skip images
                }

                // Initial state for button
                $addToCartBtn.addClass('disabled');
            });
        </script>
    @endpush
@endif