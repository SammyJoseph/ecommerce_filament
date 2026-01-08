@extends('layouts.site')
@section('title', 'Checkout | Norda - Minimal eCommerce')

@section('header-extra-classes', '') 
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active">Checkout</li>
@endsection

@section('content')
    <div class="checkout-main-area tw-pt-0 sm:tw-pt-12 pb-120">
        <div class="container">
            @livewire('checkout.checkout')
        </div>
    </div>    
@endsection