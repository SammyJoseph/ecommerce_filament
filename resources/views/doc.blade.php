<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentación Demo</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --norda-black: #1a1a1a;
            --norda-grey-bg: #F2F4F6;
            --norda-red: #ff3535;
            --text-grey: #666;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--norda-grey-bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Minimalista */
        header {
            padding-top: 50px;
            background: transparent;
            text-align: center;
        }
        .logo {
            font-weight: 800;
            font-size: 24px;
            letter-spacing: -1px;
            text-transform: uppercase;
            color: var(--norda-black);
        }
        .logo span { color: #aaa; } /* Estilo DA en Norda */

        /* Contenedor Principal */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: #fff;
            width: 100%;
            max-width: 900px;
            padding: 60px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.03);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: var(--norda-black);
            font-weight: 600;
        }

        p.subtitle {
            color: var(--text-grey);
            font-size: 16px;
            margin-bottom: 50px;
            max-width: 600px;
            line-height: 1.6;
        }

        /* Área de Selección */
        .selection-area {
            display: flex;
            justify-content: center;
            gap: 40px;
            width: 100%;
            flex-wrap: wrap;
        }

        .option-box {
            flex: 1;
            min-width: 280px;
            padding: 40px 20px;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .option-box:hover {
            border-color: var(--norda-black);
            transform: translateY(-5px);
        }

        .icon {
            font-size: 40px;
            margin-bottom: 20px;
            display: block;
        }

        h3 {
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .desc {
            font-size: 14px;
            color: #888;
            margin-bottom: 30px;
            display: block;
            min-height: 40px;
        }

        /* Botones Estilo Norda */
        .btn {
            display: inline-block;
            padding: 16px 35px;
            text-transform: uppercase;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-decoration: none;
            transition: 0.3s;
            cursor: pointer;
            width: 80%;
        }

        .btn-black {
            background-color: var(--norda-black);
            color: #fff;
            border: 1px solid var(--norda-black);
        }

        .btn-black:hover {
            background-color: var(--norda-red);
            border-color: var(--norda-red);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--norda-black);
            border: 1px solid var(--norda-black);
        }

        .btn-outline:hover {
            background-color: var(--norda-red);
            border-color: var(--norda-red);
            color: #fff;
        }

        /* Footer Simple */
        footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
        }

    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('assets/images/logo/logo-2.png') }}" alt="Logo">
        </div>
    </header>

    <main>
        <div class="card">
            <h1>Bienvenido a la Demo de tu E-commmerce</h1>
            <p class="subtitle">
                Explora la funcionalidad completa de tu nueva tienda.<br>
                Selecciona un rol a continuación para iniciar la simulación.
            </p>

            <div class="selection-area">
                <!-- Opción Comprador -->
                <div class="option-box">
                    <span class="icon">🛍️</span>
                    <h3>Frontend</h3>
                    <span class="desc">Explora productos, añade al carrito y realiza compras con tarjetas de prueba.</span>
                    <a href="{{ route('doc.login.buyer') }}" class="btn btn-black">Ingresar como Comprador</a>
                </div>

                <!-- Opción Admin -->
                <div class="option-box">
                    <span class="icon">⚙️</span>
                    <h3>Backend</h3>
                    <span class="desc">Gestiona inventario, pedidos, reportes y configuración de la tienda.</span>
                    <a href="{{ route('doc.login.admin') }}" class="btn btn-outline">Ingresar como Admin</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        Copyright © 2024 HasThemes | Built with Norda
    </footer>
</body>
</html>