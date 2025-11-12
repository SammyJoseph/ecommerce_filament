@extends('layouts.index')
@section('title', 'Checkout | Norda - Minimal eCommerce HTML Template')

@section('header-extra-classes', '') 
@section('container-class', 'container')

@section('content')
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">Checkout Page </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tw-max-w-lg tw-mx-auto">
        <div id="paymentBrick_container"></div>
    </div>
@endsection

@push('scripts')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('{{ config('services.mercadopago.public_key') }}', {
            locale: 'es-PE'
        });
        const bricksBuilder = mp.bricks();
        const renderPaymentBrick = async (bricksBuilder) => {
            const settings = {
                initialization: {
                    /*
                    "amount" es el monto total a pagar por todos los medios de pago con excepción de la Cuenta de Mercado Pago y Cuotas sin tarjeta de crédito, las cuales tienen su valor de procesamiento determinado en el backend a través del "preferenceId"
                    }
                    */
                    amount: 5000,
                    payer: {
                        firstName: "",
                        lastName: "",
                        email: "",
                    },
                },
                customization: {
                    visual: {
                        style: {
                            theme: "default",
                        },
                    },
                    paymentMethods: {
                        creditCard: "all",
                        debitCard: "all",
                        ticket: "all",
                        bankTransfer: "all",
                        onboarding_credits: "all",
                        wallet_purchase: "all",
                        atm: "all",
                        maxInstallments: 1
                    },
                },
                callbacks: {
                    onReady: () => {
                    /*
                        Callback llamado cuando el Brick está listo.
                        Aquí puede ocultar cargamentos de su sitio, por ejemplo.
                    */
                    },
                    onSubmit: ({ selectedPaymentMethod, formData }) => {
                        // callback llamado al hacer clic en el botón de envío de datos
                        return new Promise((resolve, reject) => {
                            fetch("/checkout/process_payment", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify(formData),
                            })
                            .then((response) => response.json())
                            .then((result) => {
                                if (result.status === 'success') {
                                    resolve();
                                    setTimeout(() => {
                                        window.location.href = '{{ route("thank-you") }}';
                                    }, 1000);
                                } else {
                                    reject(result.message || 'Error en el pago');
                                }
                            })
                            .catch((error) => {
                                // manejar la respuesta de error al intentar crear el pago
                                reject();
                            });
                        });
                    },
                    onError: (error) => {
                        // callback llamado para todos los casos de error de Brick
                        console.error(error);
                    },
                },
            };
            window.paymentBrickController = await bricksBuilder.create(
                "payment",
                "paymentBrick_container",
                settings
            );
        };
        renderPaymentBrick(bricksBuilder);
    </script>
@endpush