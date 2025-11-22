<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Norda - Minimal eCommerce HTML Template')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <link rel="stylesheet" href="{{  asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/vendor/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/vendor/elegant.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/vendor/linear-icon.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/plugins/nice-select.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/plugins/easyzoom.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/plugins/slick.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/plugins/animate.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/plugins/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/plugins/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{  asset('assets/css/style.css?v=0.01') }}">

    @stack('css')

    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @livewireStyles
</head>

<body>
    <div class="main-wrapper" @yield('main-wrapper-attrs')>
        @include('_partials.index.header')

        @livewire('product.side-cart')

        @include('_partials.index.mobile-header')

        @yield('content')

        @include('_partials.index.subscribe-area')

        <footer class="footer-area bg-gray pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="contact-info-wrap">
                            <div class="footer-logo">
                                <a href="#"><img src="{{ asset('assets/images/logo/logo.png') }}"></a>
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
    </div>

    <script src="{{ asset('assets/js/vendor/modernizr-3.11.7.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-v3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-migrate-v3.3.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/easyzoom.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ajax-mail.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // Sync jQuery state when Livewire opens/closes the cart
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-side-cart', () => {
                $('.sidebar-cart-active').addClass('inside');
                $('.main-wrapper').addClass('overlay-active');
            });

            Livewire.on('close-side-cart', () => {
                $('.sidebar-cart-active').removeClass('inside');
                $('.main-wrapper').removeClass('overlay-active');
            });
        });
    </script>

    @stack('scripts')
    @livewireScripts
</body>

</html>