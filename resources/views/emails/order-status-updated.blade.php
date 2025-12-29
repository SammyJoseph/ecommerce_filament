<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de tu Pedido - NORDA</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            -webkit-font-smoothing: antialiased;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        img {
            border: 0;
            display: block;
        }
        .wrapper {
            width: 100%;
            background-color: #f5f5f5;
            padding: 20px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #ffffff;
            padding: 30px 40px 20px;
            text-align: center;
            border-bottom: 1px solid #ecf0f1;
        }
        .logo {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            margin: 0;
        }
        .status-section {
            padding: 50px 40px 40px;
            text-align: center;
            background-color: #ffffff;
        }
        .status-icon {
            width: 80px;
            height: 80px;
            background-color: #e8f5e9;
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }
        /* Variantes de color para diferentes estados */
        .status-icon.received { background-color: #0cc65f29; }
        .status-icon.processing { background-color: #fff3e0; }
        .status-icon.shipped { background-color: #f3e5f5; }
        .status-icon.delivered { background-color: #e8f5e9; }
        .status-icon.cancelled { background-color: #ffebee; }
        
        .status-title {
            font-size: 28px;
            color: #2c3e50;
            margin: 0 0 15px;
            font-weight: 700;
        }
        .status-text {
            font-size: 15px;
            color: #7f8c8d;
            line-height: 1.6;
            margin: 0;
        }
        .order-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 0 40px 30px;
        }
        .detail-row {
            padding: 10px 0;
            border-bottom: 1px solid #ecf0f1;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-size: 13px;
            color: #95a5a6;
            margin: 0 0 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-value {
            font-size: 16px;
            color: #2c3e50;
            margin: 0;
            font-weight: 600;
        }
        .button-container {
            text-align: center;
            padding: 0 40px 40px;
        }
        .button {
            display: inline-block;
            padding: 14px 35px;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 3px;
            text-transform: uppercase;
        }
        .button-secondary {
            background-color: transparent;
            color: #2c3e50;
            border: 2px solid #2c3e50;
            margin-left: 10px;
        }
        .info-section {
            padding: 30px 40px;
            background-color: #f8f9fa;
            border-top: 1px solid #ecf0f1;
        }
        .info-text {
            font-size: 14px;
            color: #7f8c8d;
            line-height: 1.6;
            margin: 0;
            text-align: center;
        }
        .footer {
            background-color: #2c3e50;
            padding: 30px 40px;
            text-align: center;
        }
        .footer-text {
            font-size: 12px;
            color: #bdc3c7;
            line-height: 1.6;
            margin: 0;
        }
        .footer-link {
            color: #bdc3c7;
            text-decoration: underline;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                border-radius: 0 !important;
            }
            .header, .status-section, .button-container, .info-section, .footer {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
            .order-details {
                margin-left: 20px !important;
                margin-right: 20px !important;
                padding: 20px !important;
            }
            .status-title {
                font-size: 24px !important;
            }
            .button {
                display: block !important;
                margin: 0 0 10px !important;
            }
            .button-secondary {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="container" width="600" cellpadding="0" cellspacing="0">
                    <!-- Header -->
                    <tr>
                        <td class="header">
                            <h1 class="logo">NORDA</h1>
                        </td>
                    </tr>

                    <!-- Status Section -->
                    <tr>
                        <td class="status-section">
                            @php
                                $statusCfig = [
                                    'pending_payment' => [
                                        'class' => 'processing',
                                        'icon' => '📄',
                                        'title' => 'Pedido Recibido',
                                        'message' => 'Hemos recibido tu pedido correctamente. Estamos a la espera de la confirmación del pago.',
                                    ],
                                    'payment_confirmed' => [
                                        'class' => 'received',
                                        'icon' => '✔️',
                                        'title' => '¡Gracias por tu compra!',
                                        'message' => 'Hemos recibido correctamente tu pago y tu pedido está siendo procesado.',
                                    ],
                                    'processing' => [
                                        'class' => 'processing',
                                        'icon' => '📦',
                                        'title' => 'En Preparación',
                                        'message' => 'Estamos preparando tu pedido para enviarlo lo antes posible.',
                                    ],
                                    'shipped' => [
                                        'class' => 'shipped',
                                        'icon' => '🚚',
                                        'title' => '¡En Camino!',
                                        'message' => 'Tu pedido ha salido de nuestro almacén y está en camino a tu dirección.',
                                    ],
                                    'delivered' => [
                                        'class' => 'delivered',
                                        'icon' => '🏠',
                                        'title' => '¡Pedido Entregado!',
                                        'message' => 'Esperamos que disfrutes tu compra. Gracias por confiar en nosotros.',
                                    ],
                                    'cancelled' => [
                                        'class' => 'cancelled',
                                        'icon' => '❌',
                                        'title' => 'Pedido Cancelado',
                                        'message' => 'Tu pedido ha sido cancelado. Si tienes dudas, contáctanos.',
                                    ],
                                ];
                                
                                $currentStatus = $statusCfig[$order->status] ?? $statusCfig['processing'];
                            @endphp

                            <!-- Status Icon -->
                            <div class="status-icon {{ $currentStatus['class'] }}">
                                {{ $currentStatus['icon'] }}
                            </div>
                            
                            <!-- Status Title -->
                            <h2 class="status-title">{{ $currentStatus['title'] }}</h2>
                            
                            <!-- Status Message -->
                            <p class="status-text">
                                {{ $order->user->name }}, {{ $currentStatus['message'] }}
                            </p>
                        </td>
                    </tr>                    

                    <!-- Order Details -->
                    <tr>
                        <td>
                            <div class="order-details">
                                <h3 style="margin-top: 0; margin-bottom: 15px; color: #2c3e50; font-size: 18px;">Resumen del Pedido</h3>
                                @foreach($order->orderItems as $item)
                                <div class="order-item" style="overflow: hidden; padding: 10px 0; border-bottom: 1px solid #ecf0f1;">
                                    <span style="float: left; color: #2c3e50; font-size: 14px;">
                                        {{ $item->product->name ?? 'Producto' }} <span style="color: #7f8c8d;">x{{ $item->quantity }}</span>
                                        @php
                                            $parts = [];
                                            $options = $item->options ?? [];
                                            
                                            if (is_string($options)) {
                                                $options = json_decode($options, true);
                                            }

                                            if (is_array($options)) {
                                                if (isset($options['color'])) $parts[] = 'Color: ' . $options['color'];
                                                if (isset($options['size'])) $parts[] = 'Talla: ' . $options['size'];
                                            }
                                        @endphp
                                        @if(!empty($parts))
                                            <br><span style="color: #7f8c8d; font-size: 12px;">{{ implode(', ', $parts) }}</span>
                                        @endif
                                    </span>
                                    <span style="float: right; color: #2c3e50; font-weight: 600;">S/ {{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                                @endforeach

                                @if($order->shipping_price > 0)
                                <div class="order-item" style="overflow: hidden; padding: 10px 0; border-bottom: 1px solid #ecf0f1;">
                                    <span style="float: left; color: #2c3e50; font-size: 14px;">Envío</span>
                                    <span style="float: right; color: #2c3e50; font-weight: 600;">S/ {{ number_format($order->shipping_price, 2) }}</span>
                                </div>
                                @endif

                                @if($order->discount > 0)
                                <div class="order-item" style="overflow: hidden; padding: 10px 0; border-bottom: 1px solid #ecf0f1;">
                                    <span style="float: left; color: #2c3e50; font-size: 14px;">Descuento</span>
                                    <span style="float: right; color: #2c3e50; font-weight: 600;">- S/ {{ number_format($order->discount, 2) }}</span>
                                </div>
                                @endif

                                <div class="total-section" style="overflow: hidden; padding-top: 15px;">
                                    <span style="float: right; color: #2c3e50; font-weight: 700; font-size: 18px;">Total: S/ {{ number_format($order->grand_total, 2) }}</span>
                                </div>
                                <div style="margin-bottom: 20px;"></div>

                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="detail-row">
                                            <p class="detail-label">Número de Pedido</p>
                                            <p class="detail-value">{{ $order->number }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="detail-row">
                                            <p class="detail-label">Fecha del Pedido</p>
                                            <p class="detail-value">{{ $order->created_at->format('d F, Y') }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="detail-row">
                                            <p class="detail-label">Entrega Estimada</p>
                                            <p class="detail-value">{{ $order->created_at->addDays(3)->format('d F, Y') }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- CTA Buttons -->
                    <tr>
                        <td class="button-container">
                            <a href="{{ route('user.orders') }}" class="button">Ver mis pedidos</a>
                            <a href="#" class="button button-secondary">Contactar asesor</a>
                        </td>
                    </tr>

                    <!-- Info Section -->
                    <tr>
                        <td class="info-section">
                            <p class="info-text">
                                ¿Necesitas ayuda? Contáctanos en <strong>hello@norda.com</strong><br>
                                o llámanos al <strong>(+99) 052 158 2398</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p class="footer-text">
                                © 2025 NORDA. Todos los derechos reservados.<br>
                                8801 Glenmont Village Apt. 845, Moodybury, USA<br><br>
                                <a href="#" class="footer-link">Ver mi cuenta</a> • 
                                <a href="#" class="footer-link">Centro de ayuda</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>