@extends('layouts.site')
@section('title', 'Tienda | Norda - Minimal eCommerce')

@section('header-extra-classes', '')
@section('container-class', 'container')

{{-- @section('breadcrumbs')
    <li class="active">Tienda</li>
@endsection --}}

@section('content')
    <div class="deal-area pt-150 pb-130 bg-img" style="background-image:url(assets/images/bg/bg-1.jpg);">
        <div class="container">
            <div class="deal-content-1">
                <span>deal of the day</span>
                <h2><span>50% OFF</span> Basic <br>Tee Flavor</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipis elit. Nunc imperdiet, nulla.</p>
                <div class="timer-wrap">
                    <h4>Expires in:</h4>
                    <div class="timer-style-1" id="timer-1-active"></div>
                </div>
                <div class="deal-btn">
                    <a href="product-details.html">Buy now</a>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-area section-padding-2 tw-py-20">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="banner-wrap">
                        <div class="banner-img banner-img-zoom">
                            <a href="product-details.html"><img src="assets/images/banner/banner-8.jpg" alt=""></a>
                        </div>
                        <div class="banner-content-9">
                            <span>new arrivals <br>women</span>
                            <h2>Minimalist <br>Blazer</h2>
                            <p>A collection in minilaist style for basic blazer</p>
                            <div class="btn-style-1">
                                <a class="btn-1-padding-3 bg-white banner-btn-res" href="product-details.html">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner-wrap">
                        <div class="banner-img banner-img-zoom">
                            <a href="product-details.html"><img src="assets/images/banner/banner-9.jpg" alt=""></a>
                        </div>
                        <div class="banner-content-10">
                            <span>mega sale</span>
                            <h2><span>50%</span> OFF <br>for Autumn</h2>
                            <p>Backpack BYORK, don’t miss out in this mage sale</p>
                            <div class="btn-style-1">
                                <a class="btn-1-padding-3 bg-white banner-btn-res" href="product-details.html">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection