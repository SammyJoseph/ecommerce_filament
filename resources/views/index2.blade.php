<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Norda - Minimal eCommerce HTML Template</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">

    <link rel="stylesheet" href="{{  asset('assets2/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/vendor/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/vendor/elegant.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/vendor/linear-icon.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/plugins/nice-select.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/plugins/easyzoom.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/plugins/slick.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/plugins/animate.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/plugins/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/plugins/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{  asset('assets2/css/style.css') }}">

    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @livewireStyles
</head>

<body>
    <div class="main-wrapper" x-data="{
            product: {
                name: 'Simple Black T-Shirt',
                image: '{{ asset('assets2/images/product/product-1.jpg') }}',
                price: '',
                sale_price: '',
                description: '',
            },
            updateProductData(product) {
                this.product.name = product.name;
                this.product.image = product.image;
                this.product.price = product.price;
                this.product.sale_price = product.sale_price;
                this.product.description = product.description;
            }
        }">
        <header class="header-area transparent-bar section-padding-1">
            <div class="container-fluid">
                <div class="header-large-device">
                    <div class="header-top header-top-ptb-1 border-bottom-1">
                        <div class="row">
                            <div class="col-xl-4 col-lg-5">
                                <div class="header-offer-wrap">
                                    <p><i class="icon-paper-plane"></i> FREE SHIPPING world wide for all orders over <span>$199</span></p>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7">
                                <div class="header-top-right">
                                    <div class="same-style-wrap">
                                        <div class="same-style same-style-border track-order">
                                            <a href="order-tracking.html">Track Your Order</a>
                                        </div>
                                        <div class="same-style same-style-border language-wrap">
                                            <a class="language-dropdown-active" href="#">English <i class="icon-arrow-down"></i></a>
                                            <div class="language-dropdown">
                                                <ul>
                                                    <li><a href="#">English</a></li>
                                                    <li><a href="#">French</a></li>
                                                    <li><a href="#">German</a></li>
                                                    <li><a href="#">Spanish</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="same-style same-style-border currency-wrap">
                                            <a class="currency-dropdown-active" href="#">US Dollar <i class="icon-arrow-down"></i></a>
                                            <div class="currency-dropdown">
                                                <ul>
                                                    <li><a href="#">USD</a></li>
                                                    <li><a href="#">EUR</a></li>
                                                    <li><a href="#">Real</a></li>
                                                    <li><a href="#">BDT</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="social-style-1 social-style-1-mrg">
                                        <a href="#"><i class="icon-social-twitter"></i></a>
                                        <a href="#"><i class="icon-social-facebook"></i></a>
                                        <a href="#"><i class="icon-social-instagram"></i></a>
                                        <a href="#"><i class="icon-social-youtube"></i></a>
                                        <a href="#"><i class="icon-social-pinterest"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-bottom">
                        <div class="row align-items-center">
                            <div class="col-xl-2 col-lg-2">
                                <div class="logo">
                                    <a href="index.html"><img src="{{ asset('assets2/images/logo/logo.png') }}"></a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7">
                                <div class="main-menu main-menu-padding-1 main-menu-lh-1">
                                    <nav>
                                        <ul>
                                            <li><a href="index.html">HOME </a>
                                                <ul class="sub-menu-style">
                                                    <li><a href="index.html">Home version 1 </a></li>
                                                    <li><a href="index-2.html">Home version 2</a></li>
                                                    <li><a href="index-3.html">Home version 3</a></li>
                                                    <li><a href="index-4.html">Home version 4</a></li>
                                                    <li><a href="index-5.html">Home version 5</a></li>
                                                    <li><a href="index-6.html">Home version 6</a></li>
                                                    <li><a href="index-7.html">Home version 7</a></li>
                                                    <li><a href="index-8.html">Home version 8</a></li>
                                                    <li><a href="index-9.html">Home version 9</a></li>
                                                    <li><a href="index-10.html">Home version 10</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="shop.html">SHOP </a>
                                                <ul class="mega-menu-style mega-menu-mrg-1">
                                                    <li>
                                                        <ul>
                                                            <li>
                                                                <a class="dropdown-title" href="#">Shop Layout</a>
                                                                <ul>
                                                                    <li><a href="shop.html">standard style</a></li>
                                                                    <li><a href="shop-list.html">shop list style</a></li>
                                                                    <li><a href="shop-fullwide.html">shop fullwide</a></li>
                                                                    <li><a href="shop-no-sidebar.html">grid no sidebar</a></li>
                                                                    <li><a href="shop-list-no-sidebar.html">list no sidebar</a></li>
                                                                    <li><a href="shop-right-sidebar.html">shop right sidebar</a></li>
                                                                    <li><a href="store-location.html">store location</a></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-title" href="#">Products Layout</a>
                                                                <ul>
                                                                    <li><a href="product-details.html">tab style 1</a></li>
                                                                    <li><a href="product-details-2.html">tab style 2</a></li>
                                                                    <li><a href="product-details-sticky.html">sticky style</a></li>
                                                                    <li><a href="product-details-gallery.html">gallery style </a></li>
                                                                    <li><a href="product-details-affiliate.html">affiliate style</a></li>
                                                                    <li><a href="product-details-group.html">group style</a></li>
                                                                    <li><a href="product-details-fixed-img.html">fixed image style </a></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="shop.html"><img src="{{ asset('assets2/images/banner/banner-12.png') }}"></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="#">PAGES </a>
                                                <ul class="sub-menu-style">
                                                    <li><a href="about-us.html">about us </a></li>
                                                    <li><a href="cart.html">cart page</a></li>
                                                    <li><a href="checkout.html">checkout </a></li>
                                                    <li><a href="my-account.html">my account</a></li>
                                                    <li><a href="wishlist.html">wishlist </a></li>
                                                    <li><a href="compare.html">compare </a></li>
                                                    <li><a href="contact.html">contact us </a></li>
                                                    <li><a href="order-tracking.html">order tracking</a></li>
                                                    <li><a href="login-register.html">login / register </a></li>
                                                </ul>
                                            </li>
                                            <li><a href="blog.html">BLOG </a>
                                                <ul class="sub-menu-style">
                                                    <li><a href="blog.html">blog standard </a></li>
                                                    <li><a href="blog-no-sidebar.html">blog no sidebar </a></li>
                                                    <li><a href="blog-right-sidebar.html">blog right sidebar</a></li>
                                                    <li><a href="blog-details.html">blog details</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="contact.html">CONTACT </a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3">
                                <div class="header-action header-action-flex header-action-mrg-right">
                                    <div class="same-style-2 header-search-1">
                                        <a class="search-toggle" href="#">
                                            <i class="icon-magnifier s-open"></i>
                                            <i class="icon_close s-close"></i>
                                        </a>
                                        <div class="search-wrap-1">
                                            <form action="#">
                                                <input placeholder="Search products…" type="text">
                                                <button class="button-search"><i class="icon-magnifier"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="same-style-2">
                                        <a href="login-register.html"><i class="icon-user"></i></a>
                                    </div>
                                    <div class="same-style-2">
                                        <a href="wishlist.html"><i class="icon-heart"></i><span class="pro-count red">03</span></a>
                                    </div>
                                    <div class="same-style-2 header-cart">
                                        <a class="cart-active" href="#">
                                            <i class="icon-basket-loaded"></i><span class="pro-count red">02</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-small-device small-device-ptb-1">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <div class="mobile-logo">
                                <a href="index.html">
                                    <img src="{{ asset('assets2/images/logo/logo.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="header-action header-action-flex">
                                <div class="same-style-2">
                                    <a href="login-register.html"><i class="icon-user"></i></a>
                                </div>
                                <div class="same-style-2">
                                    <a href="wishlist.html"><i class="icon-heart"></i><span class="pro-count red">03</span></a>
                                </div>
                                <div class="same-style-2 header-cart">
                                    <a class="cart-active" href="#">
                                        <i class="icon-basket-loaded"></i><span class="pro-count red">02</span>
                                    </a>
                                </div>
                                <div class="same-style-2 main-menu-icon">
                                    <a class="mobile-header-button-active" href="#"><i class="icon-menu"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="sidebar-cart-active">
            <div class="sidebar-cart-all">
                <a class="cart-close" href="#"><i class="icon_close"></i></a>
                <div class="cart-content">
                    <h3>Shopping Cart</h3>
                    <ul>
                        <li class="single-product-cart">
                            <div class="cart-img">
                                <a href="#"><img src="{{ asset('assets2/images/cart/cart-1.jpg') }}"></a>
                            </div>
                            <div class="cart-title">
                                <h4><a href="#">Simple Black T-Shirt</a></h4>
                                <span> 1 × $49.00	</span>
                            </div>
                            <div class="cart-delete">
                                <a href="#">×</a>
                            </div>
                        </li>
                        <li class="single-product-cart">
                            <div class="cart-img">
                                <a href="#"><img src="{{ asset('assets2/images/cart/cart-2.jpg') }}"></a>
                            </div>
                            <div class="cart-title">
                                <h4><a href="#">Norda Backpack</a></h4>
                                <span> 1 × $49.00	</span>
                            </div>
                            <div class="cart-delete">
                                <a href="#">×</a>
                            </div>
                        </li>
                    </ul>
                    <div class="cart-total">
                        <h4>Subtotal: <span>$170.00</span></h4>
                    </div>
                    <div class="cart-checkout-btn">
                        <a class="btn-hover cart-btn-style" href="cart.html">view cart</a>
                        <a class="no-mrg btn-hover cart-btn-style" href="checkout.html">checkout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-header-active mobile-header-wrapper-style">
            <div class="clickalbe-sidebar-wrap">
                <a class="sidebar-close"><i class="icon_close"></i></a>
                <div class="mobile-header-content-area">
                    <div class="header-offer-wrap mobile-header-padding-border-4">
                        <p><i class="icon-paper-plane"></i> FREE SHIPPING world wide for all orders over <span>$199</span></p>
                    </div>
                    <div class="mobile-search mobile-header-padding-border-1">
                        <form class="search-form" action="#">
                            <input type="text" placeholder="Search here…">
                            <button class="button-search"><i class="icon-magnifier"></i></button>
                        </form>
                    </div>
                    <div class="mobile-menu-wrap mobile-header-padding-border-2">
                        <!-- mobile menu start -->
                        <nav>
                            <ul class="mobile-menu">
                                <li class="menu-item-has-children"><a href="index.html">Home</a>
                                    <ul class="dropdown">
                                        <li><a href="index.html">Home version 1 </a></li>
                                        <li><a href="index-2.html">Home version 2</a></li>
                                        <li><a href="index-3.html">Home version 3</a></li>
                                        <li><a href="index-4.html">Home version 4</a></li>
                                        <li><a href="index-5.html">Home version 5</a></li>
                                        <li><a href="index-6.html">Home version 6</a></li>
                                        <li><a href="index-7.html">Home version 7</a></li>
                                        <li><a href="index-8.html">Home version 8</a></li>
                                        <li><a href="index-9.html">Home version 9</a></li>
                                        <li><a href="index-10.html">Home version 10</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children "><a href="#">shop</a>
                                    <ul class="dropdown">
                                        <li class="menu-item-has-children"><a href="#">shop layout</a>
                                            <ul class="dropdown">
                                                <li><a href="shop.html">standard style</a></li>
                                                <li><a href="shop-list.html">shop list style</a></li>
                                                <li><a href="shop-fullwide.html">shop fullwide</a></li>
                                                <li><a href="shop-no-sidebar.html">grid no sidebar</a></li>
                                                <li><a href="shop-list-no-sidebar.html">list no sidebar</a></li>
                                                <li><a href="shop-right-sidebar.html">shop right sidebar</a></li>
                                                <li><a href="store-location.html">store location</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children"><a href="#">Products Layout</a>
                                            <ul class="dropdown">
                                                <li><a href="product-details.html">tab style 1</a></li>
                                                <li><a href="product-details-2.html">tab style 2</a></li>
                                                <li><a href="product-details-sticky.html">sticky style</a></li>
                                                <li><a href="product-details-gallery.html">gallery style </a></li>
                                                <li><a href="product-details-affiliate.html">affiliate style</a></li>
                                                <li><a href="product-details-group.html">group style</a></li>
                                                <li><a href="product-details-fixed-img.html">fixed image style </a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children"><a href="#">Pages</a>
                                    <ul class="dropdown">
                                        <li><a href="about-us.html">about us </a></li>
                                        <li><a href="cart.html">cart page</a></li>
                                        <li><a href="checkout.html">checkout </a></li>
                                        <li><a href="my-account.html">my account</a></li>
                                        <li><a href="wishlist.html">wishlist </a></li>
                                        <li><a href="compare.html">compare </a></li>
                                        <li><a href="contact.html">contact us </a></li>
                                        <li><a href="order-tracking.html">order tracking</a></li>
                                        <li><a href="login-register.html">login / register </a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children "><a href="#">Blog</a>
                                    <ul class="dropdown">
                                        <li><a href="blog.html">blog standard </a></li>
                                        <li><a href="blog-no-sidebar.html">blog no sidebar </a></li>
                                        <li><a href="blog-right-sidebar.html">blog right sidebar</a></li>
                                        <li><a href="blog-details.html">blog details</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contact us</a></li>
                            </ul>
                        </nav>
                        <!-- mobile menu end -->
                    </div>
                    <div class="mobile-header-info-wrap mobile-header-padding-border-3">
                        <div class="single-mobile-header-info">
                            <a href="order-tracking.html"><i class="lastudioicon-pin-3-2"></i> Track Your Order </a>
                        </div>
                        <div class="single-mobile-header-info">
                            <a class="mobile-language-active" href="#">Language <span><i class="icon-arrow-down"></i></span></a>
                            <div class="lang-curr-dropdown lang-dropdown-active">
                                <ul>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">German</a></li>
                                    <li><a href="#">Spanish</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single-mobile-header-info">
                            <a class="mobile-currency-active" href="#">Currency <span><i class="icon-arrow-down"></i></span></a>
                            <div class="lang-curr-dropdown curr-dropdown-active">
                                <ul>
                                    <li><a href="#">USD</a></li>
                                    <li><a href="#">EUR</a></li>
                                    <li><a href="#">Real</a></li>
                                    <li><a href="#">BDT</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-contact-info mobile-header-padding-border-4">
                        <ul>
                            <li><i class="icon-phone "></i> (+612) 2531 5600</li>
                            <li><i class="icon-envelope-open "></i> norda@domain.com</li>
                            <li><i class="icon-home"></i> PO Box 1622 Colins Street West Australia</li>
                        </ul>
                    </div>
                    <div class="mobile-social-icon">
                        <a class="facebook" href="#"><i class="icon-social-facebook"></i></a>
                        <a class="twitter" href="#"><i class="icon-social-twitter"></i></a>
                        <a class="pinterest" href="#"><i class="icon-social-pinterest"></i></a>
                        <a class="instagram" href="#"><i class="icon-social-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
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
                                    <img class="animated" src="{{ asset('assets2/images/slider/hm-1-slider-3.png') }}">
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
                                            @livewire('product.add-to-cart', ['product' => $product, 'classes' => ''])
                                        </div>
                                            <div class="product-action-right tooltip-style">
                                                <button
                                                    x-on:click="updateProductData({{ json_encode([
                                                        'name' => $product->name,
                                                        'image' => $product->getFirstMediaUrl('product_images', 'preview'),
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
        <footer class="footer-area bg-gray pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="contact-info-wrap">
                            <div class="footer-logo">
                                <a href="#"><img src="{{ asset('assets2/images/logo/logo.png') }}"></a>
                            </div>
                            <div class="single-contact-info">
                                <span>Our Location</span>
                                <p>869 General Village Apt. 645, Moorebury, USA</p>
                            </div>
                            <div class="single-contact-info">
                                <span>24/7 hotline:</span>
                                <p>(+99) 052 128 2399</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="footer-right-wrap">
                            <div class="footer-menu">
                                <nav>
                                    <ul>
                                        <li><a href="index.html">home</a></li>
                                        <li><a href="shop.html">Shop</a></li>
                                        <li><a href="shop.html">Product </a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                        <li><a href="blog.html">Blog.</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="social-style-2 social-style-2-mrg">
                                <a href="#"><i class="social_twitter"></i></a>
                                <a href="#"><i class="social_facebook"></i></a>
                                <a href="#"><i class="social_googleplus"></i></a>
                                <a href="#"><i class="social_instagram"></i></a>
                                <a href="#"><i class="social_youtube"></i></a>
                            </div>
                            <div class="copyright">
                                <p>Copyright © 2022 HasThemes | <a href="https://hasthemes.com/">Built with <span>Norda</span> by HasThemes</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
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
                                        <img x-bind:src="product.image" alt="">
                                    </div>
                                </div>
                                <div class="quickview-wrap mt-15">
                                    <div class="nav nav-style-6" role="tablist">
                                        <button class="nav-link active" id="pro-1-tab" data-bs-toggle="tab" data-bs-target="#pro-1" type="button" role="tab" aria-controls="pro-1" aria-selected="true">
                                            <img src="assets2/images/product/quickview-s1.jpg" alt="product-thumbnail">
                                        </button>
                                        <button class="nav-link" id="pro-2-tab" data-bs-toggle="tab" data-bs-target="#pro-2" type="button" role="tab" aria-controls="pro-2" aria-selected="false" tabindex="-1">
                                            <img src="assets2/images/product/quickview-s2.jpg" alt="product-thumbnail">
                                        </button>
                                        <button class="nav-link" id="pro-3-tab" data-bs-toggle="tab" data-bs-target="#pro-3" type="button" role="tab" aria-controls="pro-3" aria-selected="false" tabindex="-1">
                                            <img src="assets2/images/product/quickview-s3.jpg" alt="product-thumbnail">
                                        </button>
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
    </div>

    <script src="{{ asset('assets2/js/vendor/modernizr-3.11.7.min.js') }}"></script>
    <script src="{{ asset('assets2/js/vendor/jquery-v3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets2/js/vendor/jquery-migrate-v3.3.2.min.js') }}"></script>
    <script src="{{ asset('assets2/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets2/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/easyzoom.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('assets2/js/plugins/ajax-mail.js') }}"></script>
    <script src="{{ asset('assets2/js/main.js') }}"></script>

    @livewireScripts
</body>

</html>