@inject('headerSettings', 'App\Settings\HeaderSettings')
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="clickalbe-sidebar-wrap">
        <a class="sidebar-close"><i class="icon_close"></i></a>
        <div class="mobile-header-content-area">
            <div class="header-offer-wrap mobile-header-padding-border-4">
                <p><i class="icon-paper-plane"></i> {{ $headerSettings->top_message_text }} <span>{{ $headerSettings->top_message_amount }}</span></p>
            </div>
            <div class="mobile-search mobile-header-padding-border-1">
                <form class="search-form" action="{{ route('search') }}" method="GET" x-data="{ loading: false }" @submit="loading = true">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar…">
                    <button class="button-search" :disabled="loading" type="submit">
                        <i class="icon-magnifier" x-show="!loading"></i>
                        <svg x-show="loading" class="tw-animate-spin tw-w-4 tw-text-gray-500 tw-inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                            <circle class="tw-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="tw-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-padding-border-2">
                <nav>
                    <ul class="mobile-menu">
                        <li class="menu-item-has-children"><a href="{{ route('index') }}">Inicio</a></li>
                        <li class="menu-item-has-children "><a href="{{ route('shop') }}">Tienda</a></li>
                        <li class="menu-item-has-children "><a href="{{ route('about') }}">Nosotros</a></li>
                        <li class="menu-item-has-children "><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ route('contact') }}">Contacto</a></li>
                    </ul>
                </nav>
            </div>
            <div class="mobile-header-info-wrap mobile-header-padding-border-3">
                <div class="single-mobile-header-info">
                    <a href="{{ $headerSettings->track_order_url }}"><i class="lastudioicon-pin-3-2"></i> {{ $headerSettings->track_order_text }} </a>
                </div>
                <div class="single-mobile-header-info">
                    <a class="mobile-language-active" href="#">{{ $headerSettings->languages[0]['name'] ?? 'Language' }} <span><i class="icon-arrow-down"></i></span></a>
                    <div class="lang-curr-dropdown lang-dropdown-active">
                        <ul>
                            @foreach($headerSettings->languages as $language)
                                <li><a href="{{ $language['url'] }}">{{ $language['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="single-mobile-header-info">
                    <a class="mobile-currency-active" href="#">{{ $headerSettings->currencies[0]['name'] ?? 'Currency' }} <span><i class="icon-arrow-down"></i></span></a>
                    <div class="lang-curr-dropdown curr-dropdown-active">
                        <ul>
                            @foreach($headerSettings->currencies as $currency)
                                <li><a href="{{ $currency['url'] }}">{{ $currency['name'] }}</a></li>
                            @endforeach
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
                @foreach($headerSettings->social_links as $social)
                    <a class="{{ str($social['icon'])->afterLast('-') }}" href="{{ $social['url'] }}">
                        <i class="{{ $social['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>