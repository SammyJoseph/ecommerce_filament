<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(Str::random(8)),
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'value' => $this->faker->randomFloat(2, 5, 100),
            'min_cart_amount' => $this->faker->optional()->randomFloat(2, 50, 200),
            'expires_at' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'usage_limit' => $this->faker->optional()->numberBetween(10, 100),
            'is_active' => $this->faker->boolean(90), // 90% chance of being true
        ];
    }
}