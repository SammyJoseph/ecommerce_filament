@extends('layouts.site')
@section('title', 'Shop | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('content')
    <div class="breadcrumb-area bg-gray tw-hidden sm:tw-block">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="active">Shop</li>
                </ul>
            </div>
        </div>
    </div>

    @livewire('shop')
@endsection