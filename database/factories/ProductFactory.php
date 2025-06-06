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

        return [
            'category_id' => Category::query()->exists() ? Category::query()->inRandomOrder()->first()->id : null,
            'name' => $name,
            'slug' => $slugBase . '-' . fake()->unique()->randomNumber(6),
            'description' => fake()->optional(0.85)->paragraphs(fake()->numberBetween(1, 4), true), // 85% prob.
            'price' => fake()->randomFloat(2, 100, 900),
            'stock' => fake()->numberBetween(0, 200),
            'is_visible' => fake()->boolean(80),
            'is_featured' => fake()->boolean(20),
        ];
    }

    /**
     * Adjuntar imagen después de crear el producto
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            try {
                $imageWidth = 800;
                $imageHeight = 600;
                $imageUrl = 'https://picsum.photos/' . $imageWidth . '/' . $imageHeight . '?random=' . rand(1, 1000);

                $product->addMediaFromUrl($imageUrl) // Descarga la imagen desde la URL y la añade a la colección 'product_images'
                    ->preservingOriginal() // Opcional: si quieres guardar el original además de conversiones
                    ->toMediaCollection('product_images'); // <-- ¡USA EL MISMO NOMBRE DE COLECCIÓN que en tu Resource y Modelo!

            } catch (\Exception $e) {
                Log::error("Failed to add media for product ID {$product->id}: " . $e->getMessage());
            }
        });
    }
}
