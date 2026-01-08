@extends('layouts.site')
@section('title', 'Blog | Norda - Minimal eCommerce')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('breadcrumbs')
    <li class="active">Blog</li>
@endsection

@section('content')
    @livewire('blog')
@endsection