@extends('layouts.account')

@section('account-content')
    <h3>Order Details (#{{ $order->number ?? $order->id }})</h3>
    <div class="myaccount-table table-responsive text-center">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>
                            @php
                                $options = $item->options ?? [];
                                if (is_string($options)) {
                                    $options = json_decode($options, true);
                                }
                                $imagePath = $options['image'] ?? $item->product->image; 
                                
                                if ($imagePath && filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                    $imageUrl = $imagePath;
                                } elseif ($imagePath) {
                                    $imageUrl = asset('storage/' . $imagePath);
                                } else {
                                    $imageUrl = 'https://ui-avatars.com/api/?name='.urlencode($item->product->name);
                                }
                            @endphp
                            <img class="tw-max-h-16 tw-rounded" src="{{ $imageUrl }}" alt="{{ $item->product->name }}">
                        </td>
                        <td>
                            <div class="product-name">
                                {{ $item->product->name }}
                            </div>
                            @php
                                $options = $item->options;
                                if (is_string($options)) {
                                    $options = json_decode($options, true);
                                }
                            @endphp
                            @if(!empty($options) && is_array($options))
                                <div class="product-variant-info tw-text-sm tw-text-gray-500 tw-mt-1">
                                    @if(isset($options['color']))
                                        <span class="tw-mr-2">Color: {{ $options['color'] }}</span>
                                    @endif
                                    @if(isset($options['size']))
                                        <span>Talla: {{ $options['size'] }}</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->price }}</td>
                        <td>${{ $item->quantity * $item->price }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right">Subtotal</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">Shipping</td>
                    <td>${{ number_format($order->shipping_amount, 2) }}</td>
                </tr>
                <tr class="tw-bg-gray-50">
                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                    <td><strong>${{ $order->total_amount + $order->shipping_amount }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <div class="d-flex align-items-center gap-2 mb-2">
            <strong>Status:</strong>
            @php
                 // Keeping this block empty or removed since logic is moved to Model
            @endphp
            <span class="{{ $order->status_color_class }}" style="display: flex; align-items: center; gap: 5px;">
                @if($order->status_icon)
                    @svg($order->status_icon, ['style' => 'width: 18px; height: 18px;'])
                @endif
                {{ $order->status_label }}
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
