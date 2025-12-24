@extends('layouts.site')
@section('title', 'My Account | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active">My Account</li>
@endsection

@section('content')
    <div class="my-account-wrapper tw-pt-5 sm:tw-pt-20 lg:tw-pt-24 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-page-wrapper">
                        <div class="row">
                            {{-- Sidebar --}}
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="{{ route('user.my-account') }}" class="{{ request()->routeIs('user.my-account') ? 'active' : '' }}">
                                        <i class="fa fa-dashboard"></i>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('user.orders') }}" class="{{ request()->routeIs('user.orders') || request()->routeIs('user.order.details') ? 'active' : '' }}">
                                        <i class="fa fa-cart-arrow-down"></i> 
                                        Orders
                                    </a>
                                    <a href="{{ route('user.payment-method') }}" class="{{ request()->routeIs('user.payment-method') ? 'active' : '' }}">
                                        <i class="fa fa-credit-card"></i> 
                                        Payment Method
                                    </a>
                                    <a href="{{ route('user.address') }}" class="{{ request()->routeIs('user.address') ? 'active' : '' }}">
                                        <i class="fa fa-map-marker"></i> 
                                        Address
                                    </a>
                                    <a href="{{ route('user.details') }}" class="{{ request()->routeIs('user.details') ? 'active' : '' }}">
                                        <i class="fa fa-user"></i> 
                                        Account Details
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <a href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            <i class="fa fa-sign-out"></i> Logout
                                        </a>
                                    </form>
                                </div>
                            </div>                            
                            {{-- Content --}}
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <div class="myaccount-content">
                                        @yield('account-content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
