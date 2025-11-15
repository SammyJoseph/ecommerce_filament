<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class MPController extends Controller
{
    public function success(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $externalReference = $request->get('external_reference'); // Tu ORDER-ID
        
        // Verificar el pago con la API de MercadoPago
        $payment = $this->getPaymentInfo($paymentId);
        
        if ($payment && $payment->status === 'approved') {
            // Actualizar tu orden en la base de datos
            $this->updateOrderStatus($externalReference, 'paid');
            
            return view('payment.success', [
                'payment' => $payment,
                'orderId' => $externalReference
            ]);
        }
        
        return redirect()->route('payment.failure');
    }
    
    public function failure(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $externalReference = $request->get('external_reference');
        
        // Opcional: registrar el intento fallido
        $this->updateOrderStatus($externalReference, 'failed');
        
        return view('payment.failure', [
            'message' => 'El pago no pudo ser procesado. Intenta nuevamente.'
        ]);
    }
    
    public function pending(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $externalReference = $request->get('external_reference');
        
        $this->updateOrderStatus($externalReference, 'pending');
        
        return view('payment.pending', [
            'message' => 'Tu pago está siendo procesado. Te notificaremos cuando se confirme.'
        ]);
    }

    private function getPaymentInfo($paymentId)
    {
        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
            $client = new PaymentClient();
            return $client->get($paymentId);
        } catch (\Exception $e) {
            Log::error('Error getting payment info: ' . $e->getMessage());
            return null;
        }
    }

    private function updateOrderStatus($externalReference, $status)
    {
        // Actualiza tu orden en la base de datos
        // Order::where('reference', $externalReference)->update(['status' => $status]);
    }
}
