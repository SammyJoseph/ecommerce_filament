@extends('layouts.account')

@section('account-content')
    <h3>Account Details</h3>
    <div class="account-details-form">
        <form action="{{ route('user.update-account') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="single-input-item">
                        <label for="first-name" class="required">First Name</label>
                        <input type="text" id="first-name" name="name" required value="{{ old('name', $user->name) }}" />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-input-item">
                        <label for="last-name" class="required">Last Name</label>
                        <input type="text" id="last-name" name="last_name" required value="{{ old('last_name', $user->last_name) }}" />
                        @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="single-input-item">
                <label for="email" class="required">Email Address</label>
                <input type="email" id="email" name="email" required value="{{ old('email', $user->email) }}" />
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <fieldset>
                <legend>Password change</legend>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="new-pwd" class="required">New Password</label>
                            <input type="password" id="new-pwd" name="new_password" />
                             @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="confirm-pwd" class="required">Confirm Password</label>
                            <input type="password" id="confirm-pwd" name="new_password_confirmation" />
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="single-input-item">
                <button class="check-btn sqr-btn ">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
