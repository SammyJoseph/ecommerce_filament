@extends('layouts.index')
@section('title', 'My Account | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '')
@section('container-class', 'container')

@section('content')
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="active">My Account</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="my-account-wrapper pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" class="{{ !isset($order) && !request()->has('page') ? 'active' : '' }}" data-bs-toggle="tab">
                                        <i class="fa fa-dashboard"></i>
                                        Dashboard
                                    </a>
                                    <a href="{{ isset($order) ? route('user.my-account').'#orders' : '#orders' }}" class="{{ isset($order) || request()->has('page') ? 'active' : '' }}" @if(!isset($order)) data-bs-toggle="tab" @endif><i class="fa fa-cart-arrow-down"></i> Orders</a>
                                    <a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i> Download</a>
                                    <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payment
                                        Method</a>
                                    <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i> address</a>
                                    <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account Details</a>
                                    <a href="login-register.html"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade {{ !isset($order) && !request()->has('page') ? 'show active' : '' }}" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong>{{ $user->name }}</strong></p>
                                            </div>

                                            <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>

                                            <button type="button" class="tw-text-gray-900 tw-bg-white tw-border tw-border-gray-300 focus:tw-outline-none hover:tw-bg-gray-100 focus:tw-ring-4 focus:tw-ring-gray-100 tw-font-medium tw-rounded-lg tw-text-sm tw-px-5 tw-py-2.5 tw-mt-4 dark:tw-bg-gray-800 dark:tw-text-white dark:tw-border-gray-600 dark:hover:tw-bg-gray-700 dark:hover:tw-border-gray-600 dark:focus:tw-ring-gray-700">
                                                Logout
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade {{ request()->has('page') ? 'show active' : '' }}" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Price</th>
                                                            <th>Shipping</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($orders as $listOrder)
                                                            <tr>
                                                                <td><a href="{{ route('user.order.details', $listOrder) }}">{{ $listOrder->number }}</a></td>
                                                                <td>{{ $listOrder->created_at->format('M d, Y') }} <span class="tw-opacity-70">{{ $listOrder->created_at->format('g:i A') }}</span></td>
                                                                <td>
                                                                    @php
                                                                        $status = $listOrder->status;
                                                                        $config = match($status) {
                                                                            'pending' => ['class' => 'text-info', 'icon' => 'heroicon-m-sparkles'],
                                                                            'processing' => ['class' => 'text-warning', 'icon' => 'heroicon-m-arrow-path'],
                                                                            'shipped' => ['class' => 'text-success', 'icon' => 'heroicon-m-truck'],
                                                                            'delivered' => ['class' => 'text-success', 'icon' => 'heroicon-m-check-badge'],
                                                                            'cancelled' => ['class' => 'text-danger', 'icon' => 'heroicon-m-x-circle'],
                                                                            default => ['class' => 'text-secondary', 'icon' => null],
                                                                        };
                                                                    @endphp
                                                                    <span class="{{ $config['class'] }}" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                                                        @if($config['icon'])
                                                                            @svg($config['icon'], ['style' => 'width: 18px; height: 18px;'])
                                                                        @endif
                                                                        {{ ucfirst($status) }}
                                                                    </span>
                                                                </td>
                                                                <td>${{ $listOrder->total_amount }}</td>
                                                                <td>${{ $listOrder->shipping_amount }}</td>
                                                                <td>${{ number_format($listOrder->total_amount + $listOrder->shipping_amount, 2) }}</td>
                                                                <td>
                                                                    <a href="{{ route('user.order.details', $listOrder) }}" class="check-btn sqr-btn tw-text-zinc-800">
                                                                        <svg class="tw-w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z"/></svg>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="5">No orders found.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-4">
                                                {{ $orders->links() }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade {{ isset($order) ? 'show active' : '' }}" id="order-details" role="tabpanel">
                                        <div class="myaccount-content">
                                            @if(isset($order))
                                                <h3>Order Details (#{{ $order->id }})</h3>
                                                <div class="myaccount-table table-responsive text-center">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Quantity</th>
                                                                <th>Price</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order->orderItems as $item)
                                                                <tr>
                                                                    <td>{{ $item->product->name }}</td>
                                                                    <td>{{ $item->quantity }}</td>
                                                                    <td>${{ $item->price }}</td>
                                                                    <td>${{ $item->quantity * $item->price }}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="3" class="text-right">Subtotal</td>
                                                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="text-right">Shipping</td>
                                                                <td>${{ number_format($order->shipping_amount, 2) }}</td>
                                                            </tr>
                                                            <tr class="tw-bg-gray-50">
                                                                <td colspan="3" class="text-right"><strong>Total</strong></td>
                                                                <td><strong>${{ $order->total_amount + $order->shipping_amount }}</strong></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <strong>Status:</strong>
                                                        @php
                                                            $status = $order->status;
                                                            $config = match($status) {
                                                                'pending' => ['class' => 'text-info', 'icon' => 'heroicon-m-sparkles'],
                                                                'processing' => ['class' => 'text-warning', 'icon' => 'heroicon-m-arrow-path'],
                                                                'shipped' => ['class' => 'text-success', 'icon' => 'heroicon-m-truck'],
                                                                'delivered' => ['class' => 'text-success', 'icon' => 'heroicon-m-check-badge'],
                                                                'cancelled' => ['class' => 'text-danger', 'icon' => 'heroicon-m-x-circle'],
                                                                default => ['class' => 'text-secondary', 'icon' => null],
                                                            };
                                                        @endphp
                                                        <span class="{{ $config['class'] }}" style="display: flex; align-items: center; gap: 5px;">
                                                            @if($config['icon'])
                                                                @svg($config['icon'], ['style' => 'width: 18px; height: 18px;'])
                                                            @endif
                                                            {{ ucfirst($status) }}
                                                        </span>
                                                    </div>
                                                    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                                    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="download" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Downloads</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Date</th>
                                                            <th>Expire</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Haven - Free Real Estate PSD Template</td>
                                                            <td>Aug 22, 2022</td>
                                                            <td>Yes</td>
                                                            <td><a href="#" class="check-btn sqr-btn "><i class="fa fa-cloud-download"></i> Download File</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>HasTech - Profolio Business Template</td>
                                                            <td>Sep 12, 2022</td>
                                                            <td>Never</td>
                                                            <td><a href="#" class="check-btn sqr-btn "><i class="fa fa-cloud-download"></i> Download File</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Payment Method</h3>
                                            <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    @include('user._partials.address')
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Account Details</h3>
                                            <div class="account-details-form">
                                                <form action="#">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="first-name" class="required">First Name</label>
                                                                <input type="text" id="first-name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="last-name" class="required">Last Name</label>
                                                                <input type="text" id="last-name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-input-item">
                                                        <label for="display-name" class="required">Display Name</label>
                                                        <input type="text" id="display-name" />
                                                    </div>
                                                    <div class="single-input-item">
                                                        <label for="email" class="required">Email Addres</label>
                                                        <input type="email" id="email" />
                                                    </div>
                                                    <fieldset>
                                                        <legend>Password change</legend>
                                                        <div class="single-input-item">
                                                            <label for="current-pwd" class="required">Current Password</label>
                                                            <input type="password" id="current-pwd" />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="new-pwd" class="required">New Password</label>
                                                                    <input type="password" id="new-pwd" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="confirm-pwd" class="required">Confirm Password</label>
                                                                    <input type="password" id="confirm-pwd" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="single-input-item">
                                                        <button class="check-btn sqr-btn ">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            if (window.location.hash === '#orders') {
                $('a[href="#orders"]').tab('show');
            }
        });
    </script>
@endpush