<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Create 50 orders distributed throughout 2025
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $selectedProducts = $products->random(rand(1, 3));

            $total = 0;
            $orderItems = [];

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 5);
                $price = $product->price ?? 10; // fallback
                $total += $quantity * $price;
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ];
            }

            // Create random date in 2025 up to yesterday
            $startOfYear = \Carbon\Carbon::create(2025, 1, 1);
            $yesterday = \Carbon\Carbon::yesterday()->endOfDay();
            $randomDate = \Carbon\Carbon::createFromTimestamp(
                rand($startOfYear->timestamp, $yesterday->timestamp)
            );

            // 80% completed, 15% pending, 5% cancelled for realistic distribution
            $statusWeights = [
                'delivered' => 50,
                'shipped' => 20,
                'processing' => 10,
                'pending' => 15,
                'cancelled' => 5,
            ];
            $status = $this->getRandomWeighted($statusWeights);

            $order = Order::create([
                'user_id' => $user->id,
                'number' => 'OR-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'total_amount' => $total,
                'status' => $status,
                'currency' => 'usd',
                'shipping_street' => 'Sample Street ' . ($i + 1),
                'shipping_city' => 'Sample City',
                'shipping_state' => 'Sample State',
                'shipping_zip' => '12345',
                'shipping_country' => 'Sample Country',
                'notes' => 'Auto-generated order',
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }
        }
    }

    private function getRandomWeighted(array $weights): string
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);

        foreach ($weights as $item => $weight) {
            $random -= $weight;
            if ($random <= 0) {
                return $item;
            }
        }

        return array_key_first($weights);
    }
}
