<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class MPController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function success(Request $request)
    {
        
    }
    
    public function failure(Request $request)
    {
        
    }
    
    public function pending(Request $request)
    {
        
    }

    public function webhook(Request $request)
    {
        $data = $request->all();
        Log::info('MP Webhook received', ['full_payload' => $data]);

        if (isset($data['type']) && $data['type'] === 'payment') {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
            $client = new PaymentClient();
            $payment = $client->get($data['data']['id']);

            if ($payment->status === 'approved') {
                Log::info('MP payment approved webhook received for payment ID: ' . $data['data']['id']);
                
                // Convert payment object to array and process order
                $paymentData = $this->paymentToArray($payment);
                $order = $this->orderService->createOrderFromPayment($paymentData);
                
                if ($order) {
                    Log::info('Order created successfully from webhook', [
                        'order_id' => $order->id,
                        'payment_id' => $data['data']['id']
                    ]);
                } else {
                    Log::error('Failed to create order from webhook payment', [
                        'payment_id' => $data['data']['id']
                    ]);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Convert payment object to array format for OrderService
     *
     * @param mixed $payment
     * @return array
     */
    private function paymentToArray($payment): array
    {
        return [
            'id' => $payment->id ?? null,
            'external_reference' => $payment->external_reference ?? null,
            'status' => $payment->status ?? null,
            'transaction_amount' => $payment->transaction_amount ?? 0,
            'shipping_amount' => $payment->shipping_amount ?? 0,
            'payer' => [
                'email' => $payment->payer->email ?? null,
                'name' => $payment->payer->first_name ?? null,
                'surname' => $payment->payer->last_name ?? null,
            ],
            'additional_info' => [
                'items' => $this->getItemsFromPayment($payment),
            ],
        ];
    }

    /**
     * Extract items from payment additional info
     * Matches the structure from CheckoutController
     *
     * @param mixed $payment
     * @return array
     */
    private function getItemsFromPayment($payment): array
    {
        $items = [];
        
        // Try to get items from additional_info->items
        if (isset($payment->additional_info->items) && is_array($payment->additional_info->items)) {
            foreach ($payment->additional_info->items as $item) {
                $items[] = [
                    "id" => $item->id ?? null,
                    "title" => $item->title ?? 'Unknown Product',
                    "quantity" => $item->quantity ?? 1,
                    "unit_price" => (float) ($item->unit_price ?? 0),
                    "color" => $item->color ?? null,
                    "size" => $item->size ?? null,
                ];
            }
        }
        
        // Fallback: try to get from order->items if available
        elseif (isset($payment->order->items) && is_array($payment->order->items)) {
            foreach ($payment->order->items as $item) {
                $items[] = [
                    "id" => $item->id ?? null,
                    "title" => $item->title ?? 'Unknown Product',
                    "quantity" => $item->quantity ?? 1,
                    "unit_price" => (float) ($item->unit_price ?? 0),
                    "color" => $item->color ?? null,
                    "size" => $item->size ?? null,
                ];
            }
        }
        
        return $items;
    }
}
