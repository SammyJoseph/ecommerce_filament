@extends('layouts.site')
@section('title', 'Tienda | Norda - Minimal eCommerce')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('breadcrumbs')
    <li><a href="{{ route('shop.index') }}">Tienda</a></li>
    <li class="active">{{ $category->name }}</li>
@endsection

@section('content')
    @livewire('shop', ['parent_category' => $category])
@endsection