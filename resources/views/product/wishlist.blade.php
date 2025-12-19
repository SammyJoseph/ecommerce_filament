@extends('layouts.site')
@section('title', 'Wishlist | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '') 
@section('container-class', 'container')

@section('content')
    <div class="breadcrumb-area bg-gray tw-py-6">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">Wishlist </li>
                </ul>
            </div>
        </div>
    </div>

    @livewire('wishlist')
@endsection