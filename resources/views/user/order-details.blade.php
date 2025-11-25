@extends('layouts.account')

@section('account-content')
    <h3>Order Details (#{{ $order->number ?? $order->id }})</h3>
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
        <p class="tw-mb-1"><strong>Shipping Address:</strong> {{ $order->shippingAddress->address }}</p>
        <p>{{ $order->shippingAddress->department }}, {{ $order->shippingAddress->province }}, {{ $order->shippingAddress->district }}</p>
        
        <div class="mt-4">
            <a href="{{ route('user.orders') }}" class="check-btn sqr-btn">Back to Orders</a>
        </div>
    </div>
@endsection
