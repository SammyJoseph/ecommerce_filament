<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrderFromPayment(array $paymentData): ?Order
    {
        Log::info('Processing payment in OrderService', ['id' => $paymentData['id'] ?? 'N/A']);

        try {
            DB::beginTransaction();

            $externalReference = $paymentData['external_reference'] ?? null;
            
            if (!$externalReference) {
                Log::error('OrderService: No external_reference found in payment data', ['paymentData' => $paymentData]);
                return null;
            }

            $order = Order::find($externalReference);

            if (!$order) {
                Log::error('OrderService: Order not found for external_reference', ['external_reference' => $externalReference]);
                return null;
            }

            Log::info('OrderService: Order found', ['order_id' => $order->id]);

            $order->status = 'processing';
            $order->shipping_amount = $paymentData['shipping_amount'] ?? 0;
            $order->total_amount = $this->calculateTotalAmount($paymentData);
            
            if (!$order->user_id) {
                $userId = $this->getUserIdFromPayment($paymentData);
                $order->user_id = $userId;
            }

            if ($order->user_id) {
                $user = User::find($order->user_id);
                if ($user) {
                    $user->assignRole('customer');
                    $user->removeRole('user');
                }
            }
            
            $order->save();

            DB::commit();
            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing order from webhook: ' . $e->getMessage());
            return null;
        }
    }

    private function calculateTotalAmount(array $paymentData): float
    {
        return isset($paymentData['transaction_amount']) ? (float) $paymentData['transaction_amount'] : 0.00;
    }
    
    private function getUserIdFromPayment(array $paymentData): ?int
    {
        $email = $paymentData['payer']['email'] ?? null;
        
        if (!$email) return 1; 
        
        $user = User::where('email', $email)->first();
        if ($user) return $user->id;
        
        $firstName = $paymentData['payer']['name'] ?? 'Guest';
        $lastName = $paymentData['payer']['surname'] ?? 'User';
        
        $phoneData = $paymentData['payer']['phone'] ?? [];
        $phoneNumber = isset($phoneData['number']) ? ($phoneData['area_code'] ?? '') . $phoneData['number'] : '';

        try {
            $user = User::create([
                'email' => $email,
                'name' => $firstName,
                'last_name' => $lastName,
                'phone_number' => $phoneNumber,
                'password' => bcrypt(uniqid()),
            ]);
            
            return $user->id;

        } catch (\Exception $e) {
            Log::error('Error creating user in Webhook: ' . $e->getMessage());
            return 1;
        }
    }
}