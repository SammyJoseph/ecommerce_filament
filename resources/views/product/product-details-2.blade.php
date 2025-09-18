@extends('layouts.index2')
@section('title', $product->name . ' | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('content')
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">product details 2</li>
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
                            @if($product->hasVariants && !empty($variantCombinations['colors']))
                                @php
                                    $firstColor = array_key_first($variantCombinations['colors']);
                                    $currentImage = $variantCombinations['colors'][$firstColor]['image'];
                                    $currentThumb = $variantCombinations['colors'][$firstColor]['thumb'];
                                @endphp
                                <div class="easyzoom-style">
                                    <div class="easyzoom easyzoom--overlay">
                                        <a href="{{ $currentImage ?: '/assets/images/product/default.jpg' }}" id="main-image-link">
                                            <img src="{{ $currentImage ?: '/assets/images/product/default.jpg' }}" alt="{{ $product->name }}" id="main-image">
                                        </a>
                                    </div>
                                    <a class="easyzoom-pop-up img-popup" href="{{ $currentImage ?: '/assets/images/product/default.jpg' }}" id="zoom-link"><i class="icon-size-fullscreen"></i></a>
                                </div>
                            @else
                                @foreach($product->getMedia('product_images') as $media)
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ $media->getUrl('preview') }}">
                                                <img src="{{ $media->getUrl('preview') }}" alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        <a class="easyzoom-pop-up img-popup" href="{{ $media->getUrl('preview') }}"><i class="icon-size-fullscreen"></i></a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="product-dec-left product-dec-slider-small-2 product-dec-small-style2">
                            @if($product->hasVariants && $product->variants)
                                @foreach($product->variants->where('is_visible', true) as $index => $variant)
                                    @if($variant->getFirstMedia('variant_images'))
                                        @php
                                            $variantColor = null;
                                            $variantSize = null;

                                            // Find color and size for this variant
                                            if(isset($variant->options) && $variant->options) {
                                                foreach($variant->options as $option) {
                                                    if(isset($option->option) && $option->option) {
                                                        if($option->option->type === 'color') {
                                                            $variantColor = $option->value;
                                                        } elseif($option->option->type === 'size') {
                                                            $variantSize = $option->value;
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        <div class="product-dec-small {{ $index == 0 ? 'active' : '' }}"
                                             data-variant-id="{{ $variant->id }}"
                                             data-color="{{ $variantColor }}"
                                             data-size="{{ $variantSize }}">
                                            <img src="{{ $variant->getFirstMediaUrl('variant_images', 'thumb') }}" alt="{{ $product->name }}">
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                @foreach($product->getMedia('product_images') as $index => $media)
                                    <div class="product-dec-small {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ $media->getUrl('thumb') }}" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
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
                        <p>{{ $product->description }}</p>
                        <div class="pro-details-price">
                            @if($product->hasVariants && !empty($variantCombinations['combinations']))
                                @php
                                    // Get first combination for initial display
                                    $firstCombination = reset($variantCombinations['combinations']);
                                    $displayPrice = $firstCombination['price'];
                                    $displaySalePrice = $firstCombination['sale_price'];
                                @endphp
                                @if($displaySalePrice && $displaySalePrice < $displayPrice)
                                    <span class="new-price" id="current-price">${{ number_format($displaySalePrice, 2) }}</span>
                                    <span class="old-price" id="original-price">${{ number_format($displayPrice, 2) }}</span>
                                @else
                                    <span class="new-price" id="current-price">${{ number_format($displayPrice, 2) }}</span>
                                @endif
                            @else
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                @endif
                            @endif
                        </div>
                        <div class="pro-details-color-wrap">
                            <span>Color:</span>
                            <div class="pro-details-color-content">
                                <ul id="color-options">
                                    @if($product->hasVariants && !empty($variantCombinations['colors']))
                                        @foreach($variantCombinations['colors'] as $index => $color)
                                            <li>
                                                <a class="color-option {{ $index == 0 ? 'active' : '' }}"
                                                   href="#"
                                                   data-color="{{ $color['value'] }}"
                                                   data-color-code="{{ $color['color_code'] }}"
                                                   data-available-sizes="{{ json_encode($color['available_sizes']) }}"
                                                   data-image="{{ $color['image'] }}"
                                                   data-thumb="{{ $color['thumb'] }}"
                                                   style="background-color: {{ $color['color_code'] }}"
                                                   title="{{ $color['value'] }}">
                                                    <span class="color-name">{{ $color['value'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li><a class="default active" href="#" style="background-color: #ccc;">Default</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="pro-details-size">
                            <span>Size:</span>
                            <div class="pro-details-size-content">
                                <ul id="size-options">
                                    @if($product->hasVariants && !empty($variantCombinations['sizes']))
                                        @foreach($variantCombinations['sizes'] as $index => $size)
                                            <li>
                                                <a href="#"
                                                   data-size="{{ $size['value'] }}"
                                                   data-available-colors="{{ json_encode($size['available_colors']) }}"
                                                   class="disabled"
                                                   style="opacity: 0.3; pointer-events: none;">
                                                   {{ $size['value'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li><a href="#" class="active">One Size</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="pro-details-quality">
                            <span>Quantity:</span>
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" id="quantity-input">
                            </div>
                        </div>
                        @if($product->hasVariants && !empty($variantCombinations['combinations']))
                        <div class="pro-details-stock">
                            <span id="stock-info">Stock: <span id="current-stock">0</span> available</span>
                        </div>
                        @endif
                        <div class="product-details-meta">
                            <ul>
                                <li><span>Categories:</span> <a href="#">Woman,</a> <a href="#">Dress,</a> <a href="#">T-Shirt</a></li>
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
    <div class="description-review-wrapper pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dec-review-topbar nav mb-45">
                        <a class="active" data-bs-toggle="tab" href="#des-details1">Description</a>
                        <a data-bs-toggle="tab" href="#des-details2">Specification</a>
                        <a data-bs-toggle="tab" href="#des-details3">Meterials </a>
                        <a data-bs-toggle="tab" href="#des-details4">Reviews and Ratting </a>
                    </div>
                    <div class="tab-content dec-review-bottom">
                        <div id="des-details1" class="tab-pane active">
                            <div class="description-wrap">
                                <p>Crafted in premium watch quality, fenix Chronos is the first Garmin timepiece to combine a durable metal case with integrated performance GPS to support navigation and sport. In the tradition of classic tool watches it features a tough design and a set of modern meaningful tools.</p>
                                <p> advanced performance metrics for endurance sports, Garmin quality navigation features and smart notifications. In fenix Chronos top-tier performance meets sophisticated design in a highly evolved timepiece that fits your style anywhere, anytime. Solid brushed 316L stainless steel case with brushed stainless steel bezel and integrated EXOTM antenna for GPS + GLONASS support. High-strength scratch resistant sapphire crystal. Brown vintage leather strap with hand-sewn contrast stitching and nubuck inner lining and quick release mechanism.</p>
                            </div>
                        </div>
                        <div id="des-details2" class="tab-pane">
                            <div class="specification-wrap table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="title width1">Name</td>
                                            <td>Salwar Kameez</td>
                                        </tr>
                                        <tr>
                                            <td class="title width1">SKU</td>
                                            <td>0x48e2c</td>
                                        </tr>
                                        <tr>
                                            <td class="title width1">Models</td>
                                            <td>FX 829 v1</td>
                                        </tr>
                                        <tr>
                                            <td class="title width1">Categories</td>
                                            <td>Digital Print</td>
                                        </tr>
                                        <tr>
                                            <td class="title width1">Size</td>
                                            <td>60’’ x 40’’</td>
                                        </tr>
                                        <tr>
                                            <td class="title width1">Brand </td>
                                            <td>Individual Collections</td>
                                        </tr>
                                        <tr>
                                            <td class="title width1">Color</td>
                                            <td>Black, White</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="des-details3" class="tab-pane">
                            <div class="specification-wrap table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="title width1">Top</td>
                                            <td>Cotton Digital Print Chain Stitch Embroidery Work</td>
                                        </tr>
                                        <tr>
                                            <td class="title width1">Bottom</td>
                                            <td>Cotton Cambric</td>
                                        </tr>
                                        <tr>
                                            <td class="title width1">Dupatta</td>
                                            <td>Digital Printed Cotton Malmal With Chain Stitch</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="des-details4" class="tab-pane">
                            <div class="review-wrapper">
                                <h2>1 review for Sleeve Button Cowl Neck</h2>
                                <div class="single-review">
                                    <div class="review-img">
                                        <img src="assets/images/product-details/client-1.png" alt="">
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap">
                                            <div class="review-name">
                                                <h5><span>John Snow</span> - March 14, 2019</h5>
                                            </div>
                                            <div class="review-rating">
                                                <i class="yellow icon_star"></i>
                                                <i class="yellow icon_star"></i>
                                                <i class="yellow icon_star"></i>
                                                <i class="yellow icon_star"></i>
                                                <i class="yellow icon_star"></i>
                                            </div>
                                        </div>
                                        <p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque</p>
                                    </div>
                                </div>
                            </div>
                            <div class="ratting-form-wrapper">
                                <span>Add a Review</span>
                                <p>Your email address will not be published. Required fields are marked <span>*</span></p>
                                <div class="ratting-form">
                                    <form action="#">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="rating-form-style mb-20">
                                                    <label>Name <span>*</span></label>
                                                    <input type="text">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="rating-form-style mb-20">
                                                    <label>Email <span>*</span></label>
                                                    <input type="email">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="star-box-wrap">
                                                    <div class="single-ratting-star">
                                                        <a href="#"><i class="icon_star"></i></a>
                                                    </div>
                                                    <div class="single-ratting-star">
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                    </div>
                                                    <div class="single-ratting-star">
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                    </div>
                                                    <div class="single-ratting-star">
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                    </div>
                                                    <div class="single-ratting-star">
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                        <a href="#"><i class="icon_star"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="rating-form-style mb-20">
                                                    <label>Your review <span>*</span></label>
                                                    <textarea name="Your Review"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-submit">
                                                    <input type="submit" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="related-product pb-115">
        <div class="container">
            <div class="section-title mb-45 text-center">
                <h2>Related Product</h2>
            </div>
            <div class="related-product-active">
                <div class="product-plr-1">
                    <div class="single-product-wrap">
                        <div class="product-img product-img-zoom mb-15">
                            <a href="product-details.html">
                                <img src="assets/images/product/product-13.jpg" alt="">
                            </a>
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
                            <h3><a href="product-details.html">Basic Joggin Shorts</a></h3>
                            <div class="product-price-2">
                                <span>$20.50</span>
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
                            <h3><a href="product-details.html">Basic Joggin Shorts</a></h3>
                            <div class="product-price-2">
                                <span>$20.50</span>
                            </div>
                            <div class="pro-add-to-cart">
                                <button title="Add to Cart">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-plr-1">
                    <div class="single-product-wrap">
                        <div class="product-img product-img-zoom mb-15">
                            <a href="product-details.html">
                                <img src="assets/images/product/product-14.jpg" alt="">
                            </a>
                            <span class="pro-badge left bg-red">-20%</span>
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
                            <h3><a href="product-details.html">Make Thing Happen T-Shirt</a></h3>
                            <div class="product-price-2">
                                <span class="new-price">$35.45</span>
                                <span class="old-price">$45.80</span>
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
                            <h3><a href="product-details.html">Make Thing Happen T-Shirt</a></h3>
                            <div class="product-price-2">
                                <span class="new-price">$35.45</span>
                                <span class="old-price">$45.80</span>
                            </div>
                            <div class="pro-add-to-cart">
                                <button title="Add to Cart">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-plr-1">
                    <div class="single-product-wrap">
                        <div class="product-img product-img-zoom mb-15">
                            <a href="product-details.html">
                                <img src="assets/images/product/product-15.jpg" alt="">
                            </a>
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
                            <h3><a href="product-details.html">Basic White Simple Sneaker</a></h3>
                            <div class="product-price-2">
                                <span>$35.45</span>
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
                            <h3><a href="product-details.html">Basic White Simple Sneaker</a></h3>
                            <div class="product-price-2">
                                <span>$35.45</span>
                            </div>
                            <div class="pro-add-to-cart">
                                <button title="Add to Cart">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-plr-1">
                    <div class="single-product-wrap">
                        <div class="product-img product-img-zoom mb-15">
                            <a href="product-details.html">
                                <img src="assets/images/product/product-18.jpg" alt="">
                            </a>
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
                            <h3><a href="product-details.html">Tie-up Sute Sandals</a></h3>
                            <div class="product-price-2">
                                <span>$55.50</span>
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
                            <h3><a href="product-details.html">Tie-up Sute Sandals</a></h3>
                            <div class="product-price-2">
                                <span>$55.50</span>
                            </div>
                            <div class="pro-add-to-cart">
                                <button title="Add to Cart">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-plr-1">
                    <div class="single-product-wrap">
                        <div class="product-img product-img-zoom mb-15">
                            <a href="product-details.html">
                                <img src="assets/images/product/product-19.jpg" alt="">
                            </a>
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
                            <h3><a href="product-details.html">Faded Grey T-Shirt</a></h3>
                            <div class="product-price-2">
                                <span>$65.50</span>
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
                            <h3><a href="product-details.html">Faded Grey T-Shirt</a></h3>
                            <div class="product-price-2">
                                <span>$65.50</span>
                            </div>
                            <div class="pro-add-to-cart">
                                <button title="Add to Cart">Add To Cart</button>
                            </div>
                        </div>
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
                                <div id="pro-1" class="tab-pane fade show active">
                                    <img src="assets/images/product/product-1.jpg" alt="">
                                </div>
                                <div id="pro-2" class="tab-pane fade">
                                    <img src="assets/images/product/product-3.jpg" alt="">
                                </div>
                                <div id="pro-3" class="tab-pane fade">
                                    <img src="assets/images/product/product-6.jpg" alt="">
                                </div>
                            </div>
                            <div class="quickview-wrap mt-15">
                                <div class="nav nav-style-6">
                                    <button class="nav-link active" id="pro-1-tab" data-bs-toggle="tab" data-bs-target="#pro-1" type="button" role="tab"
                                        aria-controls="pro-1" aria-selected="true">
                                        <img src="assets/images/product/quickview-s1.jpg" alt="product-thumbnail">
                                    </button>
                                    <button class="nav-link" id="pro-2-tab" data-bs-toggle="tab" data-bs-target="#pro-2" type="button" role="tab"
                                        aria-controls="pro-2" aria-selected="true">
                                        <img src="assets/images/product/quickview-s2.jpg" alt="product-thumbnail">
                                    </button>
                                    <button class="nav-link" id="pro-3-tab" data-bs-toggle="tab" data-bs-target="#pro-3" type="button" role="tab"
                                        aria-controls="pro-3" aria-selected="true">
                                        <img src="assets/images/product/quickview-s3.jpg" alt="product-thumbnail">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 col-12 col-sm-12">
                            <div class="product-details-content quickview-content">
                                <h2>Simple Black T-Shirt</h2>
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
                                <p>Seamlessly predominate enterprise metrics without performance based process improvements.</p>
                                <div class="pro-details-price">
                                    <span class="new-price">$75.72</span>
                                    <span class="old-price">$95.72</span>
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
                                    <span>Size:</span>
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
                                    <span>Quantity:</span>
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                                    </div>
                                </div>
                                <div class="product-details-meta">
                                    <ul>
                                        <li><span>Categories:</span> <a href="#">Woman,</a> <a href="#">Dress,</a> <a href="#">T-Shirt</a></li>
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
        </div>
    </div>

    @if($product->hasVariants && !empty($variantCombinations['combinations']))
    <style>
        .pro-details-size-content a {
            transition: opacity 0.3s ease, background-color 0.3s ease;
        }
        .pro-details-size-content a.disabled {
            cursor: not-allowed;
            background-color: #f5f5f5 !important;
            color: #ccc !important;
        }
        .pro-details-size-content a.disabled:hover {
            background-color: #f5f5f5 !important;
            color: #ccc !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantCombinations = @json($variantCombinations);
            let selectedColor = null;
            let selectedSize = null;
            let selectedThumbnailIndex = 0; // Track which thumbnail is selected
            let isThumbnailManuallySelected = false; // Track if user manually selected a thumbnail

            // Initialize - select first color and update available sizes
            const firstColorOption = document.querySelector('#color-options .color-option');

            if (firstColorOption) {
                selectedColor = firstColorOption.dataset.color;
                firstColorOption.classList.add('active');
                updateAvailableOptions(); // Update sizes based on selected color

                // Auto-select first available size for the selected color
                if (variantCombinations.colors[selectedColor]) {
                    const availableSizes = variantCombinations.colors[selectedColor].available_sizes;
                    if (availableSizes.length > 0) {
                        const firstAvailableSize = availableSizes[0];
                        const sizeOption = document.querySelector(`#size-options a[data-size="${firstAvailableSize}"]`);
                        if (sizeOption) {
                            selectedSize = firstAvailableSize;
                            sizeOption.classList.add('active');
                        }
                    }
                }
            }

            updateStockDisplay();

            // Initialize product images for the first selected color
            if (selectedColor) {
                updateProductImages();
            }

            // Add hover effect for zoom functionality
            const mainImageContainer = document.querySelector('.easyzoom');
            if (mainImageContainer) {
                mainImageContainer.addEventListener('mouseenter', function() {
                    // Store current image URL for zoom
                    const mainImage = document.getElementById('main-image');
                    if (mainImage) {
                        const zoomLink = document.getElementById('zoom-link');
                        if (zoomLink) {
                            zoomLink.href = mainImage.src;
                        }
                    }
                });
            }

            // Color selection handler
            document.querySelectorAll('#color-options .color-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all colors
                    document.querySelectorAll('#color-options .color-option').forEach(opt => {
                        opt.classList.remove('active');
                    });

                    // Add active class to selected color
                    this.classList.add('active');
                    selectedColor = this.dataset.color;

                    // Reset thumbnail selection when color is changed manually
                    isThumbnailManuallySelected = false;

                    // Reset size selection
                    document.querySelectorAll('#size-options a').forEach(opt => {
                        opt.classList.remove('active');
                    });
                    selectedSize = null;

                    updateAvailableOptions();

                    // Auto-select first available size for the new color
                    if (variantCombinations.colors[selectedColor]) {
                        const availableSizes = variantCombinations.colors[selectedColor].available_sizes;
                        if (availableSizes.length > 0) {
                            const firstAvailableSize = availableSizes[0];
                            const sizeOption = document.querySelector(`#size-options a[data-size="${firstAvailableSize}"]`);
                            if (sizeOption) {
                                selectedSize = firstAvailableSize;
                                sizeOption.classList.add('active');
                            }
                        }
                    }

                    updateStockDisplay();
                    updateProductImages();
                });
            });

            // Size selection handler
            document.querySelectorAll('#size-options a').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Only allow selection if this size is available for the selected color
                    if (selectedColor && variantCombinations.colors[selectedColor]) {
                        const availableSizes = variantCombinations.colors[selectedColor].available_sizes;
                        if (!availableSizes.includes(this.dataset.size)) {
                            return; // Don't allow selection of unavailable sizes
                        }
                    }

                    // Remove active class from all sizes
                    document.querySelectorAll('#size-options a').forEach(opt => {
                        opt.classList.remove('active');
                    });

                    // Add active class to selected size
                    this.classList.add('active');
                    selectedSize = this.dataset.size;

                    updateStockDisplay();
                });
            });

            function updateAvailableOptions() {
                // Reset all sizes to disabled initially
                document.querySelectorAll('#size-options a').forEach(option => {
                    option.classList.add('disabled');
                    option.style.opacity = '0.3';
                    option.style.pointerEvents = 'none';
                });

                // Enable only sizes available for the selected color
                if (selectedColor && variantCombinations.colors[selectedColor]) {
                    const availableSizes = variantCombinations.colors[selectedColor].available_sizes;

                    document.querySelectorAll('#size-options a').forEach(option => {
                        const sizeValue = option.dataset.size;
                        if (availableSizes.includes(sizeValue)) {
                            option.classList.remove('disabled');
                            option.style.opacity = '1';
                            option.style.pointerEvents = 'auto';
                        }
                    });
                }

                // All colors remain available (no filtering based on size)
                document.querySelectorAll('#color-options .color-option').forEach(option => {
                    option.classList.remove('disabled');
                    option.style.opacity = '1';
                    option.style.pointerEvents = 'auto';
                });
            }

            function updateStockDisplay() {
                const stockElement = document.getElementById('current-stock');
                const currentPriceElement = document.getElementById('current-price');
                const originalPriceElement = document.getElementById('original-price');
                const quantityInput = document.getElementById('quantity-input');

                if (selectedColor && selectedSize) {
                    const combinationKey = selectedColor + '-' + selectedSize;
                    const combination = variantCombinations.combinations[combinationKey];

                    if (combination) {
                        // Update stock
                        if (stockElement) {
                            stockElement.textContent = combination.stock;
                        }

                        // Update price
                        if (combination.sale_price && combination.sale_price < combination.price) {
                            // Has sale price
                            if (currentPriceElement) {
                                currentPriceElement.textContent = '$' + parseFloat(combination.sale_price).toFixed(2);
                            }
                            if (originalPriceElement) {
                                originalPriceElement.textContent = '$' + parseFloat(combination.price).toFixed(2);
                                originalPriceElement.style.display = 'inline';
                            }
                        } else {
                            // No sale price
                            if (currentPriceElement) {
                                currentPriceElement.textContent = '$' + parseFloat(combination.price).toFixed(2);
                            }
                            if (originalPriceElement) {
                                originalPriceElement.style.display = 'none';
                            }
                        }

                        // Update quantity input max
                        if (quantityInput) {
                            quantityInput.max = combination.stock;
                            if (parseInt(quantityInput.value) > combination.stock) {
                                quantityInput.value = combination.stock;
                            }
                        }
                    } else {
                        // No valid combination found
                        if (stockElement) stockElement.textContent = '0';
                        if (quantityInput) quantityInput.max = 0;
                    }
                } else {
                    // No selection made yet
                    if (stockElement) stockElement.textContent = '0';
                    if (quantityInput) quantityInput.max = 0;
                }
            }

            function updateProductImages() {
                if (selectedColor && variantCombinations.colors[selectedColor]) {
                    // If user hasn't manually selected a thumbnail, use color image
                    // If user has manually selected a thumbnail, keep that image
                    let imageUrl;
                    if (!isThumbnailManuallySelected) {
                        const colorData = variantCombinations.colors[selectedColor];
                        imageUrl = colorData.image || '/assets/images/product/default.jpg';
                    } else {
                        // Keep the current image from the manually selected thumbnail
                        const thumbnails = document.querySelectorAll('.product-dec-small');
                        if (thumbnails[selectedThumbnailIndex]) {
                            const thumbImg = thumbnails[selectedThumbnailIndex].querySelector('img');
                            if (thumbImg) {
                                imageUrl = thumbImg.src;
                                if (imageUrl.includes('thumb')) {
                                    imageUrl = imageUrl.replace('/thumb/', '/preview/');
                                }
                            }
                        }
                    }

                    // Update main image
                    const mainImage = document.getElementById('main-image');
                    const mainImageLink = document.getElementById('main-image-link');
                    const zoomLink = document.getElementById('zoom-link');

                    if (mainImage && imageUrl) {
                        mainImage.src = imageUrl;
                        mainImage.alt = `{{ $product->name }} - ${selectedColor}`;
                    }

                    if (mainImageLink && imageUrl) {
                        mainImageLink.href = imageUrl;
                    }

                    if (zoomLink && imageUrl) {
                        zoomLink.href = imageUrl;
                    }

                    // Find and activate the thumbnail that corresponds to this color
                    const thumbnails = document.querySelectorAll('.product-dec-small');
                    let foundMatchingThumbnail = false;

                    thumbnails.forEach((thumb, index) => {
                        thumb.classList.remove('active');
                        const thumbColor = thumb.dataset.color;

                        // If this thumbnail matches the selected color, activate it
                        if (thumbColor === selectedColor) {
                            thumb.classList.add('active');
                            selectedThumbnailIndex = index;
                            foundMatchingThumbnail = true;
                        }
                    });

                    // If no matching thumbnail found, try to keep the current thumbnail active
                    // or activate the first one as fallback
                    if (!foundMatchingThumbnail && thumbnails.length > 0) {
                        if (selectedThumbnailIndex < thumbnails.length) {
                            thumbnails[selectedThumbnailIndex].classList.add('active');
                        } else {
                            thumbnails[0].classList.add('active');
                            selectedThumbnailIndex = 0;
                        }
                    }
                }
            }

            function updateMainImageFromThumbnail(thumbnailIndex) {
                const thumbnails = document.querySelectorAll('.product-dec-small');
                if (thumbnails[thumbnailIndex]) {
                    const thumbImg = thumbnails[thumbnailIndex].querySelector('img');
                    if (thumbImg) {
                        const mainImage = document.getElementById('main-image');
                        const mainImageLink = document.getElementById('main-image-link');
                        const zoomLink = document.getElementById('zoom-link');

                        // Convert thumb URL to full image URL
                        let fullImageUrl = thumbImg.src;
                        if (fullImageUrl.includes('thumb')) {
                            fullImageUrl = fullImageUrl.replace('/thumb/', '/preview/');
                        }

                        // Update main image
                        if (mainImage) {
                            mainImage.src = fullImageUrl;
                            mainImage.alt = `{{ $product->name }} - Thumbnail ${thumbnailIndex + 1}`;
                        }

                        // Update links
                        if (mainImageLink) {
                            mainImageLink.href = fullImageUrl;
                        }

                        if (zoomLink) {
                            zoomLink.href = fullImageUrl;
                        }

                        // Mark as manually selected
                        isThumbnailManuallySelected = true;
                        selectedThumbnailIndex = thumbnailIndex;
                    }
                }
            }

            // Add thumbnail click functionality
            document.querySelectorAll('.product-dec-small').forEach((thumb, index) => {
                thumb.addEventListener('click', function() {
                    // Remove active class from all thumbnails
                    document.querySelectorAll('.product-dec-small').forEach(t => {
                        t.classList.remove('active');
                    });

                    // Add active class to clicked thumbnail
                    this.classList.add('active');
                    selectedThumbnailIndex = index;

                    // Update main image from this thumbnail
                    updateMainImageFromThumbnail(index);

                    // If this thumbnail has a color, try to select that color
                    const thumbColor = this.dataset.color;
                    if (thumbColor && variantCombinations.colors[thumbColor]) {
                        // Find the color option and select it
                        const colorOption = document.querySelector(`#color-options .color-option[data-color="${thumbColor}"]`);
                        if (colorOption) {
                            // Remove active from all colors
                            document.querySelectorAll('#color-options .color-option').forEach(opt => {
                                opt.classList.remove('active');
                            });

                            // Add active to this color
                            colorOption.classList.add('active');
                            selectedColor = thumbColor;

                            // Update available sizes for this color
                            updateAvailableOptions();

                            // Auto-select first available size
                            if (variantCombinations.colors[selectedColor]) {
                                const availableSizes = variantCombinations.colors[selectedColor].available_sizes;
                                if (availableSizes.length > 0) {
                                    const firstAvailableSize = availableSizes[0];
                                    const sizeOption = document.querySelector(`#size-options a[data-size="${firstAvailableSize}"]`);
                                    if (sizeOption) {
                                        // Remove active from all sizes
                                        document.querySelectorAll('#size-options a').forEach(opt => {
                                            opt.classList.remove('active');
                                        });
                                        selectedSize = firstAvailableSize;
                                        sizeOption.classList.add('active');
                                    }
                                }
                            }

                            // Update stock and price
                            updateStockDisplay();
                        }
                    }
                });
            });
        });
    </script>
    @endif
@endsection