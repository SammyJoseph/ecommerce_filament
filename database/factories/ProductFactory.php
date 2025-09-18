<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $price = $this->faker->numberBetween(100, 500);
        $salePrice = $this->faker->optional(0.7)->numberBetween(80, $price - 10);
        $stock = $this->faker->numberBetween(10, 100);
        $description = $this->faker->paragraph;

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $description,
            'price' => $price,
            'sale_price' => $salePrice,
            'stock' => $stock,
            'is_visible' => true,
            'is_featured' => $this->faker->boolean(0.3),
        ];
    }

    // Helper to decide if product has variants (60% chance)
    public function withVariants()
    {
        return $this->state(function (array $attributes) {
            // Create products with variants (e.g., clothing)
            if ($this->faker->boolean(0.6)) {
                $optionName = $this->faker->randomElement(['Color', 'Size']);
                $optionType = $optionName === 'Color' ? 'color' : 'size';

                $options = [
                    ProductOption::create([
                        'product_id' => null, // Will be set after product creation
                        'name' => $optionName,
                        'type' => $optionType,
                    ]),
                ];

                $values = [];
                foreach ($options as $option) {
                    if ($option->type === 'color') {
                        $colorData = [
                            ['name' => 'Red', 'code' => '#FF0000'],
                            ['name' => 'Blue', 'code' => '#0000FF'],
                            ['name' => 'Green', 'code' => '#00FF00'],
                            ['name' => 'Black', 'code' => '#000000'],
                        ];
                        foreach ($colorData as $color) {
                            $values[] = ProductOptionValue::create([
                                'product_option_id' => $option->id,
                                'value' => $color['name'],
                                'color_code' => $color['code'],
                            ]);
                        }
                    } else {
                        $sizeNames = ['S', 'M', 'L', 'XL'];
                        foreach ($sizeNames as $sizeName) {
                            $values[] = ProductOptionValue::create([
                                'product_option_id' => $option->id,
                                'value' => $sizeName,
                            ]);
                        }
                    }
                }

                // Create variants with interdependent availability (Aliexpress-style: e.g., Red only in M/L)
                $variants = [];
                $combinations = [
                    ['Color' => 'Red', 'Size' => 'M'], // Available
                    ['Color' => 'Red', 'Size' => 'L'], // Available
                    ['Color' => 'Blue', 'Size' => 'L'], // Available
                    ['Color' => 'Blue', 'Size' => 'XL'], // Available (not S/M for Blue)
                ];

                foreach ($combinations as $combo) {
                    $variant = Variant::create([
                        'product_id' => null, // Will be set after
                        'price' => $this->faker->numberBetween(100, 500),
                        'sale_price' => $this->faker->optional(0.5)->numberBetween(80, $attributes['price'] - 10),
                        'stock' => $this->faker->numberBetween(5, 20), // Limited stock for realism
                    ]);

                    // Link to option values (pivot)
                    foreach ($combo as $optionName => $valueName) {
                        $option = $options[array_search($optionName, array_column($options, 'name'))];
                        $value = $values[array_search($valueName, array_column($values, 'value'))];
                        $variant->options()->attach($value->id);
                    }

                    $variants[] = $variant;
                }

                return [
                    'options' => $options,
                    'variants' => $variants,
                ];
            }

            return []; // No variants for simple products
        });
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            try {
                $imageWidth = 600;
                $imageHeight = 600;

                // Create 3 images for each product
                for ($i = 0; $i < 3; $i++) {
                    $imageUrl = 'https://picsum.photos/' . $imageWidth . '/' . $imageHeight . '?random=' . rand(1, 1000);

                    $product->addMediaFromUrl($imageUrl)
                        ->preservingOriginal()
                        ->toMediaCollection('product_images');
                }

            } catch (\Exception $e) {
                // Log error but don't stop seeding
                Log::error("Failed to add media for product ID {$product->id}: " . $e->getMessage());
            }
        });
    }
}
