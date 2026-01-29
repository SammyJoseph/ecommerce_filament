@extends('layouts.site')

@section('title', 'Payment Pending')

@section('breadcrumbs')
    <li class="active">Payment Pending</li>
@endsection

@section('content')
<div class="cart-main-area tw-pt-5 sm:tw-pt-20 lg:tw-pt-24 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="checkout-msg">
                    <i class="icon-clock" style="font-size: 50px; color: #ffc107; margin-bottom: 20px;"></i>
                    <h3 class="cart-page-title">Payment Pending</h3>
                    <p>Your payment is currently being processed. We will notify you once it's confirmed.</p>
                    <div class="btn-hover text-center mt-30">
                        <a class="btn-style-2" href="{{ route('shop.index') }}">Return to Shop</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
