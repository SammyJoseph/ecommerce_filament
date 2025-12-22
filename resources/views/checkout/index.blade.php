@extends('layouts.site')
@section('title', 'Checkout | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '') 
@section('container-class', 'container')

@section('content')
    <div class="breadcrumb-area bg-gray tw-py-6 tw-hidden sm:tw-block">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="active">Checkout</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="checkout-main-area tw-pt-0 sm:tw-pt-12 pb-120">
        <div class="container">
            @livewire('checkout.checkout')
        </div>
    </div>    
@endsection