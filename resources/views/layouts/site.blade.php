<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('_partials.index.meta')

    @include('_partials.index.styles')

    @stack('css')

    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @livewireStyles
</head>
<body>
    <div class="main-wrapper" @yield('main-wrapper-attrs')>
        @include('_partials.index.header')

        @livewire('product.side-cart')

        @include('_partials.index.mobile-header')

        @hasSection('breadcrumbs')
            <div class="breadcrumb-area bg-gray @yield('breadcrumb-padding', 'tw-py-6') tw-hidden sm:tw-block">
                <div class="container">
                    <div class="breadcrumb-content text-center">
                        <ul>
                            <li>
                                <a href="{{ route('index') }}">Home</a>
                            </li>
                            @yield('breadcrumbs')
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')

        @if(!auth()->check() || !auth()->user()->is_subscribed)
            @livewire('subscribe-user')
        @endif

        @include('_partials.index.footer')

        @include('_partials.success-alert')
        @include('_partials.error-alert')
    </div>

    @include('_partials.index.scripts')

    @stack('scripts')
    @livewireScripts
</body>
</html>