@extends('layouts.site')

@section('title', 'Payment Successful')

@section('content')
<div class="breadcrumb-area bg-gray">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('index') }}">Home</a>
                </li>
                <li class="active">Payment Successful</li>
            </ul>
        </div>
    </div>
</div>
<div class="cart-main-area pt-115 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="checkout-msg">
                    <i class="icon-check" style="font-size: 50px; color: #28a745; margin-bottom: 20px;"></i>
                    <h3 class="cart-page-title">Payment Successful!</h3>
                    <p>Thank you for your purchase. Your order has been successfully placed.</p>
                    <div class="btn-hover text-center mt-30">
                        <a class="btn-style-2" href="{{ route('shop') }}">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
