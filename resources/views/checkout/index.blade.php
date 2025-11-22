@extends('layouts.index')
@section('title', 'Checkout | Norda - Minimal eCommerce HTML Template')

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
                    <li class="active">Checkout</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="checkout-main-area pt-50 pb-120">
        <div class="container">
            <div class="checkout-wrap pt-30">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="billing-info-wrap mr-50">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>First Name <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Last Name <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Email Address <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Phone <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div> 
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Street Address <abbr class="required" title="required">*</abbr></label>
                                        <input class="billing-address" placeholder="House number and street name" type="text">
                                        <input placeholder="Reference" type="text">
                                    </div>
                                </div>                                                                                               
                            </div>
                            <div class="additional-info-wrap">
                                <label>Order notes</label>
                                <textarea placeholder="Notes about your order, e.g. special notes for delivery. " name="message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="your-order-area" x-data="{ paymentMethod: 'mercadopago' }">
                            <h3>Your order</h3>
                            <div class="your-order-wrap gray-bg-4">
                                <div class="your-order-info-wrap">
                                    <div class="your-order-info">
                                        <ul>
                                            <li>Product <span>Total</span></li>
                                        </ul>
                                    </div>
                                    <div class="your-order-middle">
                                        <ul>
                                            @foreach($cartItems as $item)
                                                <li>{{ $item->name }} X {{ $item->qty }} <span>${{ number_format($item->price, 2) }} </span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-subtotal">
                                        <ul>
                                            <li>Subtotal <span>${{ number_format($subtotal, 2) }} </span></li>
                                        </ul>
                                    </div>
                                    @if($discount > 0)
                                    <div class="your-order-info order-subtotal">
                                        <ul>
                                            <li>Discount <span>-${{ number_format($discount, 2) }} </span></li>
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="your-order-info order-shipping">
                                        <ul>
                                            <li>Shipping 
                                                <span>${{ number_format($shipping, 2) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-total">
                                        <ul>
                                            <li>Total <span>${{ number_format($total, 2) }} </span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="payment-method">                                    
                                    <div class="pay-top sin-payment sin-payment-3">
                                        <input id="payment-method-2" class="input-radio" type="radio" value="mercadopago" x-model="paymentMethod" name="payment_method">
                                        <label for="payment-method-2" class="tw-justify-between">
                                            <span>MercadoPago <img alt="" src="assets/images/icon-img/payment.png"></span>
                                            <svg class="tw-w-4 tw-text-red-500 tw-float-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
                                        </label>
                                        <div class="tw-mt-2" x-show="paymentMethod === 'mercadopago'" style="display: none;">
                                            <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference.</p>
                                        </div>
                                    </div>
                                    <div class="pay-top sin-payment sin-payment-3">
                                        <input id="payment-method-3" class="input-radio" type="radio" value="paypal" x-model="paymentMethod" name="payment_method">
                                        <label for="payment-method-3" class="tw-justify-between">
                                            <span>PayPal <img alt="" src="assets/images/icon-img/payment.png"></span>
                                            <svg class="tw-w-4 tw-text-red-500 tw-float-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
                                        </label>
                                        <div class="tw-mt-2" x-show="paymentMethod === 'paypal'" style="display: none;">
                                            <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference.</p>
                                        </div>
                                    </div>
                                    <div class="pay-top sin-payment">
                                        <input id="payment_method_1" class="input-radio" type="radio" value="bank_transfer" x-model="paymentMethod" name="payment_method">
                                        <label for="payment_method_1"> Direct Bank Transfer </label>
                                        <div class="tw-mt-2" x-show="paymentMethod === 'bank_transfer'" style="display: none;">
                                            <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="Place-order mt-25">
                                <div x-show="paymentMethod === 'bank_transfer'">
                                    <a href="#" class="btn-hover">Place Order</a>
                                </div>
                                
                                <div x-show="paymentMethod === 'mercadopago'" style="display: none;" class="tw-max-w-lg tw-mx-auto">
                                    <div id="wallet_container"></div>
                                </div>

                                <div x-show="paymentMethod === 'paypal'" style="display: none;">
                                    <a href="#" class="btn-hover">Pay with PayPal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection

@push('scripts')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('{{ config('services.mercadopago.public_key') }}', {
            locale: 'es-PE'
        });
        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: "{{ $preferenceId }}",
            },
        });
    </script>
@endpush