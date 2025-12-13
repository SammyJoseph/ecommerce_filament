<header class="header-area @yield('header-extra-classes')">
    <div class="@yield('container-class', 'container')">
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
                            <a href="{{ route('index') }}"><img src="{{ asset('assets/images/logo/logo.png') }}"></a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7">
                        <div class="main-menu main-menu-padding-1 main-menu-lh-1">
                            <nav>
                                <ul class="tw-uppercase">
                                    <li><a href="{{ route('index') }}" @class(['!tw-text-red-500' => request()->routeIs('index')])>Home</a></li>
                                    <li><a href="{{ route('shop') }}" @class(['!tw-text-red-500' => request()->routeIs('shop')])>Shop</a></li>
                                    <li><a href="{{ route('about') }}" @class(['!tw-text-red-500' => request()->routeIs('about')])>About us</a></li>
                                    <li><a href="{{ route('blog.index') }}" @class(['!tw-text-red-500' => request()->routeIs('blog.index')])>Blog</a></li>
                                    <li><a href="{{ route('contact') }}" @class(['!tw-text-red-500' => request()->routeIs('contact')])>Contact</a></li>
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
                                <a href="{{ route('user.my-account') }}"><i class="icon-user"></i></a>
                            </div>
                            <div class="same-style-2">
                                <a href="{{ route('wishlist') }}">
                                    <i class="icon-heart"></i>
                                    <livewire:header.wishlist-count />
                                </a>
                            </div>
                            <div class="same-style-2 header-cart">
                                <a class="cart-active" href="#">
                                    <i class="icon-basket-loaded">
                                    </i><livewire:header.cart-count />
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
                            <img src="{{ asset('assets/images/logo/logo.png') }}">
                        </a>
                    </div>
                </div>
                <div class="col-7">
                    <div class="header-action header-action-flex">
                        <div class="same-style-2">
                            <a href="{{ route('login') }}"><i class="icon-user"></i></a>
                        </div>
                        <div class="same-style-2">
                            <a href="{{ route('wishlist') }}"><i class="icon-heart"></i><livewire:header.wishlist-count /></a>
                        </div>
                        <div class="same-style-2 header-cart">
                            <a class="cart-active" href="#">
                                <i class="icon-basket-loaded"></i><livewire:header.cart-count />
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