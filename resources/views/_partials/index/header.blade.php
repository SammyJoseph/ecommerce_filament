<header class="header-area @yield('header-extra-classes')">
    <div class="@yield('container-class', 'container')">
        <div class="header-large-device">
@inject('headerSettings', 'App\Settings\HeaderSettings')
            <div class="header-top header-top-ptb-1 border-bottom-1">
                <div class="row">
                    <div class="col-xl-4 col-lg-5">
                        <div class="header-offer-wrap">
                            <p><i class="icon-paper-plane"></i> {{ $headerSettings->top_message_text }} <span>{{ $headerSettings->top_message_amount }}</span></p>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7">
                        <div class="header-top-right">
                            <div class="same-style-wrap">
                                <div class="same-style same-style-border track-order">
                                    <a href="{{ $headerSettings->track_order_url }}">{{ $headerSettings->track_order_text }}</a>
                                </div>
                                <div class="same-style same-style-border language-wrap">
                                    <a class="language-dropdown-active" href="#">{{ $headerSettings->languages[0]['name'] ?? 'Languages' }} <i class="icon-arrow-down"></i></a>
                                    <div class="language-dropdown">
                                        <ul>
                                            @foreach($headerSettings->languages as $language)
                                                <li><a href="{{ $language['url'] }}">{{ $language['name'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="same-style same-style-border currency-wrap">
                                    <a class="currency-dropdown-active" href="#">{{ $headerSettings->currencies[0]['name'] ?? 'Currency' }} <i class="icon-arrow-down"></i></a>
                                    <div class="currency-dropdown">
                                        <ul>
                                            @foreach($headerSettings->currencies as $currency)
                                                <li><a href="{{ $currency['url'] }}">{{ $currency['name'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="social-style-1 social-style-1-mrg">
                                @foreach($headerSettings->social_links as $social)
                                    <a href="{{ $social['url'] }}"><i class="{{ $social['icon'] }}"></i></a>
                                @endforeach
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
                            <div class="same-style-2 tw-relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false">
                                <a href="{{ route('user.my-account') }}" @auth @click.prevent="open = !open" @endauth>
                                    <i class="icon-user"></i>
                                    @auth
                                        <span class="tw-absolute -tw-top-1 -tw-right-1 tw-block tw-h-2 tw-w-2 tw-rounded-full tw-bg-green-400 tw-ring-2 tw-ring-white"></span>
                                    @endauth
                                </a>
                                @auth
                                    <ul class="sub-menu-style tw-absolute tw-right-0 tw-top-full tw-bg-white tw-shadow-lg tw-z-50 tw-min-w-[150px] tw-p-3 tw-rounded-b-md tw-space-y-3" 
                                        x-show="open"
                                        x-transition:enter="tw-transition tw-ease-out tw-duration-200"
                                        x-transition:enter-start="tw-opacity-0 tw-translate-y-2"
                                        x-transition:enter-end="tw-opacity-100 tw-translate-y-0"
                                        x-transition:leave="tw-transition tw-ease-in tw-duration-150"
                                        x-transition:leave-start="tw-opacity-100 tw-translate-y-0"
                                        x-transition:leave-end="tw-opacity-0 tw-translate-y-2"
                                        style="display: none;">
                                        <li><a class="!tw-text-xs" href="{{ route('user.my-account') }}">My Account</a></li>
                                        <li><a class="!tw-text-xs" href="{{ route('user.orders') }}">My Orders</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="!tw-text-xs" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    Logout
                                                    <svg class="tw-w-3 -tw-mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-84 31.5-156.5T197-763l56 56q-44 44-68.5 102T160-480q0 134 93 227t227 93q134 0 227-93t93-227q0-67-24.5-125T707-707l56-56q54 54 85.5 126.5T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-360v-440h80v440h-80Z"/></svg>
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                @endauth
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
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('assets/images/logo/logo.png') }}">
                        </a>
                    </div>
                </div>
                <div class="col-7">
                    <div class="header-action header-action-flex">
                        <div class="same-style-2 tw-relative" x-data="{ open: false }" @click.outside="open = false">
                            <a href="{{ route('user.my-account') }}" @auth @click.prevent="open = !open" @endauth>
                                <i class="icon-user"></i>
                                @auth
                                    <span class="tw-absolute -tw-top-1 -tw-right-1 tw-block tw-h-2 tw-w-2 tw-rounded-full tw-bg-green-400 tw-ring-2 tw-ring-white"></span>
                                @endauth
                            </a>
                            @auth
                                <ul class="sub-menu-style tw-absolute tw-right-0 tw-top-full tw-bg-white tw-shadow-lg tw-z-50 tw-min-w-[150px] tw-p-3 tw-rounded-b-md tw-space-y-3" 
                                    x-show="open"
                                    x-transition:enter="tw-transition tw-ease-out tw-duration-200"
                                    x-transition:enter-start="tw-opacity-0 tw-translate-y-2"
                                    x-transition:enter-end="tw-opacity-100 tw-translate-y-0"
                                    x-transition:leave="tw-transition tw-ease-in tw-duration-150"
                                    x-transition:leave-start="tw-opacity-100 tw-translate-y-0"
                                    x-transition:leave-end="tw-opacity-0 tw-translate-y-2"
                                    style="display: none;">
                                    <li><a class="!tw-text-xs" href="{{ route('user.my-account') }}">My Account</a></li>
                                    <li><a class="!tw-text-xs" href="{{ route('user.orders') }}">My Orders</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="!tw-text-xs" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                Logout
                                                <svg class="tw-w-3 -tw-mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-84 31.5-156.5T197-763l56 56q-44 44-68.5 102T160-480q0 134 93 227t227 93q134 0 227-93t93-227q0-67-24.5-125T707-707l56-56q54 54 85.5 126.5T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-360v-440h80v440h-80Z"/></svg>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            @endauth
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