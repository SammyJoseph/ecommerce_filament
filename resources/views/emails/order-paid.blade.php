<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #111827;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .order-details {
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #f9f9f9;
            padding-bottom: 10px;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
            font-size: 1.2em;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 0.8em;
            color: #777;
            background-color: #f9f9f9;
            border-radius: 0 0 8px 8px;
        }
        .btn {
            display: inline-block;
            background-color: #111827;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Gracias por tu compra!</h1>
        </div>
        <div class="content">
            <p>Hola {{ $order->user->name }},</p>
            <p>Hemos recibido correctamente tu pago. Tu orden <strong>{{ $order->number }}</strong> ha sido confirmada y está siendo procesada.</p>
            
            <div class="order-details">
                <h3>Resumen del Pedido</h3>
                @foreach($order->orderItems as $item)
                <div class="order-item" style="overflow: hidden;">
                    <span style="float: left;">{{ $item->product->name ?? 'Producto' }} (x{{ $item->quantity }})</span>
                    <span style="float: right;">S/ {{ number_format($item->price * $item->quantity, 2) }}</span>
                </div>
                @endforeach
                
                @if($order->shipping_amount > 0)
                <div class="order-item" style="overflow: hidden;">
                    <span style="float: left;">Envío</span>
                    <span style="float: right;">S/ {{ number_format($order->shipping_amount, 2) }}</span>
                </div>
                @endif
                
                <div class="total-section">
                    Total: S/ {{ number_format($order->total_amount, 2) }}
                </div>
            </div>

            <p style="text-align: center;">
                <a href="{{ route('user.orders') }}" class="btn">Ver Mis Pedidos</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
