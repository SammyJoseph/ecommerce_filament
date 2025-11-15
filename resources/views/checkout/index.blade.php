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
                    <li class="active">Checkout Page </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tw-max-w-lg tw-mx-auto">
        <div id="wallet_container"></div>
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