<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(fake()->words(fake()->numberBetween(2, 6), true));
        $slugBase = Str::slug($name);
        
        // Randomly decide if product should have variants (30% chance of having variants)
        $hasVariants = fake()->boolean(30);
        
        // If product has variants, price should be null, otherwise generate a price
        $price = $hasVariants ? null : fake()->randomFloat(2, 100, 900);
        
        $salePrice = fake()->optional(0.4)->randomFloat(
            2,
            $price ? $price * 0.5 : 0,
            $price ? $price * 0.9 : 0
        );

        return [
            'category_id' => Category::query()->exists() ? Category::query()->inRandomOrder()->first()->id : null,
            'name' => $name,
            'slug' => $slugBase . '-' . fake()->unique()->randomNumber(6),
            'description' => fake()->optional(0.85)->paragraphs(fake()->numberBetween(1, 4), true),
            'price' => $price,
            'sale_price' => $salePrice,
            'stock' => fake()->numberBetween(0, 200),
            'is_visible' => fake()->boolean(80),
            'is_featured' => fake()->boolean(20),
        ];
    }

    /**
     * Adjuntar 3 imágenes de galería y crear variantes después de crear el producto
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            try {
                // Add 3 product gallery images
                for ($i = 0; $i < 3; $i++) {
                    $imageWidth = 800;
                    $imageHeight = 600;
                    $imageUrl = 'https://picsum.photos/' . $imageWidth . '/' . $imageHeight . '?random=' . rand(1, 1000);

                    $product->addMediaFromUrl($imageUrl)
                        ->preservingOriginal()
                        ->toMediaCollection('product_images');
                }

                // Only create variants for products that should have them (30% chance)
                // We determine this based on whether the product has a price or not
                if ($product->price === null) {
                    // Create variants (1 to 5 variants per product)
                    $variantCount = fake()->numberBetween(1, 5);
                    \App\Models\Variant::factory($variantCount)->create([
                        'product_id' => $product->id,
                    ]);
                }

            } catch (\Exception $e) {
                Log::error("Failed to add media or variants for product ID {$product->id}: " . $e->getMessage());
            }
        });
    }
}
