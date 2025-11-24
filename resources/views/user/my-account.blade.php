@extends('layouts.account')

@section('account-content')
    <h3>Dashboard</h3>
    <div class="welcome">
        <p>Hello, <strong>{{ $user->name }}</strong></p>
    </div>

    <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>

    <form method="POST" action="{{ route('logout') }}" class="!tw-mt-4">
        @csrf
        <button type="submit" class="tw-text-gray-900 tw-bg-white tw-border tw-border-gray-300 focus:tw-outline-none hover:tw-bg-gray-100 focus:tw-ring-4 focus:tw-ring-gray-100 tw-font-medium tw-rounded-lg tw-text-sm tw-px-5 tw-py-2.5 dark:tw-bg-gray-800 dark:tw-text-white dark:tw-border-gray-600 dark:hover:tw-bg-gray-700 dark:hover:tw-border-gray-600 dark:focus:tw-ring-gray-700">
            Logout
        </button>
    </form>
@endsection