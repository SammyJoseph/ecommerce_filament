<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function process(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string',
            'issuer_id' => 'nullable|string',
            'paymentMethodId' => 'required|string',
            'transactionAmount' => 'required|numeric',
            'installments' => 'nullable|integer',
            'email' => 'required|email',
            'identificationType' => 'nullable|string',
            'number' => 'nullable|string',
        ]);

        // Inicializar SDK con Access Token desde config
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

        $client = new PaymentClient();

        // Opciones de request con cabecera de idempotencia
        $requestOptions = new \MPRequestOptions();
        $requestOptions->setCustomHeaders([
            'X-Idempotency-Key: ' . Str::uuid()->toString()
        ]);

        try {
            $payment = $client->create([
                'token' => $data['token'],
                'issuer_id' => $data['issuer_id'] ?? null,
                'payment_method_id' => $data['paymentMethodId'],
                'transaction_amount' => (float) $data['transactionAmount'],
                'installments' => $data['installments'] ?? 1,
                'payer' => [
                    'email' => $data['email'],
                    'identification' => [
                        'type' => $data['identificationType'] ?? null,
                        'number' => $data['number'] ?? null,
                    ],
                ],
            ], $requestOptions);

            return response()->json([
                'status' => 'success',
                'payment' => $payment
            ], 200);
        } catch (\Throwable $e) {
            Log::error('MercadoPago payment error: '.$e->getMessage(), ['payload' => $data]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
