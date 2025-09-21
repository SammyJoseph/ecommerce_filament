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
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="{{ asset('assets2/images/product-details/b-large-1.jpg') }}">
                                        <img src="{{ asset('assets2/images/product-details/large-1.jpg') }}" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="{{ asset('assets2/images/product-details/b-large-1.jpg') }}"><i class="icon-size-fullscreen"></i></a>
                            </div>
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="{{ asset('assets2/images/product-details/b-large-2.jpg') }}">
                                        <img src="{{ asset('assets2/images/product-details/large-2.jpg') }}" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="{{ asset('assets2/images/product-details/b-large-2.jpg') }}"><i class="icon-size-fullscreen"></i></a>
                            </div>
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="{{ asset('assets2/images/product-details/b-large-3.jpg') }}">
                                        <img src="{{ asset('assets2/images/product-details/large-3.jpg') }}" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="{{ asset('assets2/images/product-details/b-large-3.jpg') }}"><i class="icon-size-fullscreen"></i></a>
                            </div>
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="{{ asset('assets2/images/product-details/b-large-4.jpg') }}">
                                        <img src="{{ asset('assets2/images/product-details/large-4.jpg') }}" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="{{ asset('assets2/images/product-details/b-large-4.jpg') }}"><i class="icon-size-fullscreen"></i></a>
                            </div>
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="{{ asset('assets2/images/product-details/b-large-2.jpg') }}">
                                        <img src="{{ asset('assets2/images/product-details/large-2.jpg') }}" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="{{ asset('assets2/images/product-details/b-large-2.jpg') }}"><i class="icon-size-fullscreen"></i></a>
                            </div>
                        </div>
                        <div class="product-dec-left product-dec-slider-small-2 product-dec-small-style2">
                            <div class="product-dec-small active">
                                <img src="{{ asset('assets2/images/product-details/small-1.jpg') }}" alt="">
                            </div>
                            <div class="product-dec-small">
                                <img src="{{ asset('assets2/images/product-details/small-2.jpg') }}" alt="">
                            </div>
                            <div class="product-dec-small">
                                <img src="{{ asset('assets2/images/product-details/small-3.jpg') }}" alt="">
                            </div>
                            <div class="product-dec-small">
                                <img src="{{ asset('assets2/images/product-details/small-4.jpg') }}" alt="">
                            </div>
                            <div class="product-dec-small">
                                <img src="{{ asset('assets2/images/product-details/small-2.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="product-details-content pro-details-content-mt-md">
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

    {{-- @include('_partials.index.temp-product-details') --}}
@endsection