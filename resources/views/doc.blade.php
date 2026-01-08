<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentación Demo</title>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            box-sizing: border-box;
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
            cursor: pointer;
        }

        .option-box:hover, .option-box.active {
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
            padding: 16px 35px;
            text-transform: uppercase;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-decoration: none;
            transition: 0.3s;
            cursor: pointer;
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
        
        [x-cloak] { display: none !important; }

        /* Footer Simple */
        footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
        }

        /* Responsive para móviles */
        @media (max-width: 768px) {
            .card {
                padding: 30px 20px;
            }
            
            .option-box {
                min-width: 100%;
            }
            
            h1 {
                font-size: 26px;
            }
            
            p.subtitle {
                margin-bottom: 30px;
            }
            
            .selection-area {
                gap: 20px;
            }
        }

    </style>

    @vite('resources/css/app.css')
</head>
<body>
    <main>
        <div class="card" x-data="{ role: null }">
            <h1>Bienvenido a la Demo</h1>
            <p class="subtitle">
                Explora la funcionalidad completa de tu nueva e-commerce.<br>
                Selecciona un rol a continuación para iniciar la simulación.
            </p>

            <div class="selection-area">
                <!-- Opción Comprador -->
                <div class="option-box" :class="{ 'active': role === 'buyer' }">
                    <span class="icon">🛍️</span>
                    <h3>Comprador</h3>
                    <span class="desc">Explora productos, añade al carrito y realiza compras con tarjetas de prueba.</span>    
                    <button type="button" @click="role = 'buyer'; $nextTick(() => document.getElementById('instructions').scrollIntoView({ behavior: 'smooth' }))" class="btn btn-outline" :class="{ 'btn-black': role === 'buyer', 'btn-outline': role !== 'buyer' }">
                        <span x-text="role === 'buyer' ? 'Seleccionado' : 'Ver instrucciones'"></span>
                    </button>
                </div>

                <!-- Opción Admin -->
                <div class="option-box" :class="{ 'active': role === 'admin' }">
                    <span class="icon">⚙️</span>
                    <h3>Admin</h3>
                    <span class="desc">Gestiona inventario, pedidos, reportes y configuración de la tienda.</span>    
                    <button type="button" @click="role = 'admin'; $nextTick(() => document.getElementById('instructions').scrollIntoView({ behavior: 'smooth' }))" class="btn btn-outline" :class="{ 'btn-black': role === 'admin', 'btn-outline': role !== 'admin' }">
                        <span x-text="role === 'admin' ? 'Seleccionado' : 'Ver instrucciones'"></span>
                    </button>
                </div>
            </div>

            <div x-show="role" x-transition x-cloak id="instructions" style="margin-top: 40px; width: 100%;">                
                <!-- Instrucciones Comprador -->
                <div x-show="role === 'buyer'">
                    <h2>Instrucciones para <span class="tw-text-red-600">Comprador</span></h2>
                    <iframe class="w-full tw-aspect-video tw-max-w-3xl" src="https://www.youtube.com/embed/x91MPoITQ3I?si=s_rWDTw5VQQB-xDN&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <div class="tw-text-base tw-max-w-3xl tw-mx-auto tw-text-gray-600">
                        <p>Al acceder como usuario comprador, puedes:</p>
                        <ul class="tw-list-disc tw-list-inside">
                            <li>Agregar productos al carrito</li>
                            <li>Elegir una dirección de envío</li>
                            <li>Pagos con tarjetas de prueba</li>
                            <li>Ver historial de compras</li>
                            <li>Dejar reseñas de productos</li>
                        </ul>
                        <p class="tw-italic">La tarjeta de prueba se mostrará en la página de pago.</p>
                    </div>
                    <a href="{{ route('doc.login.buyer') }}" class="btn btn-black tw-max-w-xl tw-block tw-mx-auto tw-mt-4">Ingresar como Comprador</a>
                </div>

                <!-- Instrucciones Admin -->
                <div x-show="role === 'admin'">
                    <h2>Instrucciones para <span class="tw-text-red-600">Admin</span></h2>
                    <iframe class="w-full tw-aspect-video tw-max-w-3xl" src="https://www.youtube.com/embed/njX2bu-_Vw4?si=FHxu2iilLXCH4fp3&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <div class="tw-text-base tw-max-w-3xl tw-mx-auto tw-text-gray-600">
                        <p>Al acceder como usuario administrador, puedes:</p>
                        <ul class="tw-list-disc tw-list-inside">
                            <li>Gestionar inventario</li>
                            <li>Gestionar pedidos</li>
                            <li>Gestionar reportes</li>
                            <li>Configurar la tienda</li>
                        </ul>
                    </div>
                    <a href="{{ route('doc.login.admin') }}" class="btn btn-black tw-max-w-xl tw-block tw-mx-auto tw-mt-4">Ingresar como Admin</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        Copyright © 2024 HasThemes | Built with Norda
    </footer>
</body>
</html>