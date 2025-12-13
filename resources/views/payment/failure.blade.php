@extends('layouts.site')

@section('title', 'Payment Failed')

@section('content')
<div class="breadcrumb-area bg-gray">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('index') }}">Home</a>
                </li>
                <li class="active">Payment Failed</li>
            </ul>
        </div>
    </div>
</div>
<div class="cart-main-area pt-115 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="checkout-msg">
                    <i class="icon-close" style="font-size: 50px; color: #dc3545; margin-bottom: 20px;"></i>
                    <h3 class="cart-page-title">Payment Failed</h3>
                    <p>We were unable to process your payment. Please try again or choose a different payment method.</p>
                    <div class="btn-hover text-center mt-30">
                        <a class="btn-style-2" href="{{ route('checkout.index') }}">Try Again</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
