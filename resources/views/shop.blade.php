@extends('layouts.site')
@section('title', 'Tienda | Norda - Minimal eCommerce')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active">Tienda</li>
@endsection

@section('content')
    @livewire('shop')
@endsection