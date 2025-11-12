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
        Log::info('Checkout process started', ['request' => $request->all()]);

        try {
            $data = $request->validate([
                'token' => 'required|string',
                'issuer_id' => 'nullable|string',
                'payment_method_id' => 'required|string',
                'transaction_amount' => 'required|numeric',
                'installments' => 'nullable|integer',
                'payer.email' => 'required|email',
                'payer.identification.type' => 'nullable|string',
                'payer.identification.number' => 'nullable|string',
            ]);

            Log::info('Data validated', ['data' => $data]);

            // Inicializar SDK con Access Token desde config
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
            Log::info('MercadoPago SDK initialized');

            $client = new PaymentClient();

            Log::info('About to create payment');
            $payment = $client->create([
                'token' => $data['token'],
                'issuer_id' => $data['issuer_id'] ?? null,
                'payment_method_id' => $data['payment_method_id'],
                'transaction_amount' => (float) $data['transaction_amount'],
                'installments' => $data['installments'] ?? 1,
                'payer' => [
                    'email' => $data['payer']['email'],
                    'identification' => [
                        'type' => $data['payer']['identification']['type'] ?? null,
                        'number' => $data['payer']['identification']['number'] ?? null,
                    ],
                ],
            ]);

            Log::info('MercadoPago payment created', [
                'payment_id' => $payment->id,
                'status' => $payment->status,
                'transaction_amount' => $payment->transaction_amount,
                'payer_email' => $payment->payer->email,
            ]);

            return response()->json([
                'status' => 'success',
                'payment' => $payment
            ], 200);
        } catch (\Throwable $e) {
            Log::error('MercadoPago payment error: '.$e->getMessage(), ['payload' => $request->all()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function thanks(){
        return view('checkout.thanks');
    }
}
