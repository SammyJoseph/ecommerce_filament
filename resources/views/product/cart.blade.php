@extends('layouts.site')
@section('title', 'Cart | Norda - Minimal eCommerce HTML Template')

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
                    <li class="active">Cart Page </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-50 pb-120">
        <div class="container pt-30">
            <h3 class="cart-page-title">Your cart items</h3>
            @livewire('product.shopping-cart')
        </div>
    </div>
@endsection