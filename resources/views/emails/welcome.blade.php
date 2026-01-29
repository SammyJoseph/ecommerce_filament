<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a NORDA</title>
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
        .welcome-section {
            padding: 50px 40px 40px;
            text-align: center;
            background-color: #ffffff;
        }
        .welcome-icon {
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
        .welcome-title {
            font-size: 28px;
            color: #2c3e50;
            margin: 0 0 15px;
            font-weight: 700;
        }
        .welcome-text {
            font-size: 15px;
            color: #7f8c8d;
            line-height: 1.6;
            margin: 0;
        }
        .discount-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 0 40px 30px;
            text-align: center;
        }
        .discount-label {
            font-size: 13px;
            color: #95a5a6;
            margin: 0 0 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .discount-code {
            font-size: 24px;
            color: #2c3e50;
            margin: 0 0 10px;
            font-weight: 700;
            letter-spacing: 2px;
        }
        .discount-text {
            font-size: 14px;
            color: #7f8c8d;
            margin: 0;
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
            .header, .welcome-section, .button-container, .info-section, .footer {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
            .discount-box {
                margin-left: 20px !important;
                margin-right: 20px !important;
                padding: 20px !important;
            }
            .welcome-title {
                font-size: 24px !important;
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

                    <!-- Welcome Section -->
                    <tr>
                        <td class="welcome-section">
                            <div class="welcome-icon">👋</div>
                            <h2 class="welcome-title">¡Bienvenido, {{ $user->name }}!</h2>
                            <p class="welcome-text">
                                Gracias por unirte a nuestra comunidad. Estamos emocionados<br>
                                de tenerte con nosotros y ofrecerte productos de alta calidad.
                            </p>
                        </td>
                    </tr>

                    <!-- Discount Box -->
                    <tr>
                        <td>
                            <div class="discount-box">
                                <p class="discount-label">🎁 Regalo de Bienvenida</p>
                                <p class="discount-code">WELCOME15</p>
                                <p class="discount-text">
                                    15% de descuento en tu primera compra
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td class="button-container">
                            <a href="{{ route('shop.index') }}" class="button">Comenzar a Comprar</a>
                        </td>
                    </tr>

                    <!-- Info Section -->
                    <tr>
                        <td class="info-section">
                            <p class="info-text">
                                <strong>Envío gratis</strong> en pedidos +$50 • <strong>Devoluciones gratis</strong> en 30 días<br>
                                ¿Preguntas? Escríbenos a <strong>hello@nordal.com</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p class="footer-text">
                                © {{ date('Y') }} NORDA. Todos los derechos reservados.<br>
                                8801 Glenmont Village Apt. 845, Moodybury, USA<br><br>
                                <a href="{{ route('user.my-account') }}" class="footer-link">Mi cuenta</a> • 
                                <a href="{{ route('user.orders') }}" class="footer-link">Mis Compras</a> • 
                                <a href="#" class="footer-link">Darse de baja</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>