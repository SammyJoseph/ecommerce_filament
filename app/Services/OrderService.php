<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Create a new order from payment data
     *
     * @param array $paymentData
     * @return Order|null
     */
    public function createOrderFromPayment(array $paymentData): ?Order
    {
        try {
            // Get user from auth or payment data
            $userId = Auth::id() ?? $this->getUserIdFromPayment($paymentData);
            
            // Calculate total amount
            $totalAmount = $this->calculateTotalAmount($paymentData);
            
            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'status' => 'completed',
                'shipping_address' => $this->getShippingAddress($paymentData),
            ]);
            
            // Create order items from additional_info->items
            $this->createOrderItems($order, $paymentData);
            
            Log::info('Order created successfully from webhook', [
                'order_id' => $order->id,
                'payment_id' => $paymentData['id'] ?? null
            ]);
            
            return $order;
            
        } catch (\Exception $e) {
            Log::error('Error creating order from payment webhook: ' . $e->getMessage(), [
                'payment_data' => $paymentData
            ]);
            return null;
        }
    }
    
    /**
     * Create order items from payment additional info
     *
     * @param Order $order
     * @param array $paymentData
     * @return void
     */
    private function createOrderItems(Order $order, array $paymentData): void
    {
        if (!isset($paymentData['additional_info']['items'])) {
            Log::warning('No items found in payment additional_info');
            return;
        }
        
        $items = $paymentData['additional_info']['items'];
        
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'] ?? null,
                'quantity' => $item['quantity'] ?? 0,
                'price' => $item['unit_price'] ?? 0,
            ]);
        }
        
        Log::info('Order items created', [
            'order_id' => $order->id,
            'item_count' => count($items)
        ]);
    }
    
    /**
     * Calculate total amount from payment data
     *
     * @param array $paymentData
     * @return float
     */
    private function calculateTotalAmount(array $paymentData): float
    {
        return isset($paymentData['transaction_amount'])
            ? (float) $paymentData['transaction_amount']
            : 0.00;
    }
    
    /**
     * Get user ID from payment data
     *
     * @param array $paymentData
     * @return int|null
     */
    private function getUserIdFromPayment(array $paymentData): ?int
    {
        $email = $paymentData['payer']['email'] ?? null;
        
        if (!$email) {
            Log::warning('No email found in payment data');
            return null;
        }
        
        // Buscar usuario existente
        $user = User::where('email', $email)->first();
        
        if ($user) {
            Log::info('Found existing user', ['user_id' => $user->id, 'email' => $email]);
            return $user->id;
        }
        
        // Crear nuevo usuario si no existe
        $user = User::create([
            'email' => $email,
            'name' => $paymentData['payer']['name'] ?? 'Guest',
            'password' => bcrypt(uniqid()),
            'email_verified_at' => now(),
        ]);
        
        Log::info('Created new user from payment', ['user_id' => $user->id, 'email' => $email]);
        
        return $user->id;
    }
    
    /**
     * Get shipping address from payment data
     *
     * @param array $paymentData
     * @return string|null
     */
    private function getShippingAddress(array $paymentData): ?string
    {
        // Extract shipping address if available in payment data
        // This is a placeholder - implement based on your payment data structure
        return null;
    }
}