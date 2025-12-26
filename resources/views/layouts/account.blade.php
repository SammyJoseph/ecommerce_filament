@extends('layouts.site')
@section('title', 'My Account | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active">My Account</li>
@endsection

@section('content')
    <div class="my-account-wrapper tw-pt-5 sm:tw-pt-12 lg:tw-pt-16 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-page-wrapper">
                        <div class="row">
                            {{-- Sidebar --}}
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="{{ route('user.my-account') }}" class="{{ request()->routeIs('user.my-account') ? 'active' : '' }}">
                                        <i class="fa fa-user"></i>
                                        Account Details
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

                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <a href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            Logout
                                            <svg class="tw-w-3.5 -tw-mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-84 31.5-156.5T197-763l56 56q-44 44-68.5 102T160-480q0 134 93 227t227 93q134 0 227-93t93-227q0-67-24.5-125T707-707l56-56q54 54 85.5 126.5T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-360v-440h80v440h-80Z"/></svg>
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
