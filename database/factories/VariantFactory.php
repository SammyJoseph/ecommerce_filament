<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $colors = ['Red', 'Blue', 'Green', 'Black', 'White', 'Yellow'];
        $sizes = ['Small', 'Medium', 'Large', 'XL', 'XXL'];

        $color = fake()->randomElement($colors);
        $size = fake()->randomElement($sizes);
        $name = $color . ' - ' . $size;

        $price = fake()->randomFloat(2, 50, 200);

        return [
            'product_id' => Product::factory(), // This will create a product if not provided
            'name' => $name,
            'price' => $price,
            'sale_price' => fake()->optional(0.3)->randomFloat(2, $price * 0.5, $price * 0.9),
            'stock' => fake()->numberBetween(0, 100),
            'is_visible' => fake()->boolean(90),
        ];
    }

    /**
     * Attach image after creating the variant
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Variant $variant) {
            try {
                $imageWidth = 600;
                $imageHeight = 600;
                $imageUrl = 'https://picsum.photos/' . $imageWidth . '/' . $imageHeight . '?random=' . rand(1, 1000);

                $variant->addMediaFromUrl($imageUrl)
                    ->preservingOriginal()
                    ->toMediaCollection('variant_images');

            } catch (\Exception $e) {
                Log::error("Failed to add media for variant ID {$variant->id}: " . $e->getMessage());
            }
        });
    }
}
