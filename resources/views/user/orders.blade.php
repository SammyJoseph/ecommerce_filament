@extends('layouts.account')

@section('account-content')
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
                        <td colspan="7">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection
