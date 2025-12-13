@extends('layouts.site')
@section('title', 'Login | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('content')
    <div class="login-register-area pt-100 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ms-auto me-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-bs-toggle="tab" href="#lg1">
                                <h4>Login</h4>
                            </a>
                            <a data-bs-toggle="tab" href="#lg2">
                                <h4>Register</h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf
                                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                            <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <input type="checkbox" name="remember" id="remember">
                                                    <label for="remember">Remember me</label>
                                                    @if (Route::has('password.request'))
                                                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                                                    @endif
                                                </div>
                                                <button type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="lg2" class="tab-pane">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('register') }}" method="post">
                                            @csrf
                                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                            <input type="password" name="password" placeholder="New Password" required>
                                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                                            <div class="button-box">
                                                <button type="submit">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection