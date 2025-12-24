@extends('layouts.site')
@section('title', 'Wishlist | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '') 
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active">Wishlist </li>
@endsection

@section('content')
    @livewire('wishlist')
@endsection