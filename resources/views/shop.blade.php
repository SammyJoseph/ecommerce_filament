@extends('layouts.site')
@section('title', 'Shop | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active">Shop</li>
@endsection

@section('content')
    @livewire('shop')
@endsection