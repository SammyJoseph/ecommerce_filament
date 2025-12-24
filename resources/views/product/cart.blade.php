@extends('layouts.site')
@section('title', 'Cart | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '') 
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active">Cart Page </li>
@endsection

@section('content')
    <div class="cart-main-area tw-pt-5 sm:tw-pt-20 lg:tw-pt-24 pb-120">
        <div class="container pt-30">
            <h3 class="cart-page-title">Your cart items</h3>
            @livewire('product.shopping-cart')
        </div>
    </div>
@endsection