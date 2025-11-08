<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\Variant;
use App\Models\VariantSize;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $price = $this->faker->numberBetween(70, 200);
        $salePrice = $this->faker->optional(0.7)->numberBetween(20, $price - 10);
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

    /**
     * Create a product with variants (color-based with multiple sizes)
     */
    public function withVariants()
    {
        return $this->afterCreating(function (Product $product) {
            // Create Color option
            $colorOption = ProductOption::create([
                'product_id' => $product->id,
                'name' => 'Color',
                'type' => 'color',
            ]);

            // Create Size option
            $sizeOption = ProductOption::create([
                'product_id' => $product->id,
                'name' => 'Size',
                'type' => 'size',
            ]);

            // Define available colors
            $colorsData = [
                ['name' => 'Red', 'code' => '#FF0000'],
                ['name' => 'Blue', 'code' => '#0000FF'],
                ['name' => 'Green', 'code' => '#00FF00'],
                ['name' => 'Black', 'code' => '#000000'],
            ];

            // Define available sizes
            $sizesData = ['S', 'M', 'L', 'XL'];

            // Create color values
            $colorValues = [];
            foreach ($colorsData as $color) {
                $colorValues[] = ProductOptionValue::create([
                    'product_option_id' => $colorOption->id,
                    'value' => $color['name'],
                    'color_code' => $color['code'],
                ]);
            }

            // Create size values
            $sizeValues = [];
            foreach ($sizesData as $sizeName) {
                $sizeValues[] = ProductOptionValue::create([
                    'product_option_id' => $sizeOption->id,
                    'value' => $sizeName,
                ]);
            }

            // Create variants (one per color) with multiple sizes
            // We'll create 2-3 color variants randomly
            $selectedColors = $this->faker->randomElements($colorValues, $this->faker->numberBetween(2, 3));

            foreach ($selectedColors as $colorValue) {
                // Create variant for this color
                $variant = Variant::create([
                    'product_id' => $product->id,
                    'color_id' => $colorValue->id,
                    'sku' => $this->faker->unique()->ean13(),
                    'is_visible' => true,
                ]);

                // Add variant image (color-specific)
                try {
                    $imageWidth = 600;
                    $imageHeight = 600;
                    $imageUrl = 'https://picsum.photos/' . $imageWidth . '/' . $imageHeight . '?random=' . rand(1, 10000);

                    $variant->addMediaFromUrl($imageUrl)
                        ->preservingOriginal()
                        ->toMediaCollection('variant_images');
                } catch (\Exception $e) {
                    Log::error("Failed to add media for variant ID {$variant->id}: " . $e->getMessage());
                }

                // Select which sizes will be available for this color (2-4 sizes)
                $availableSizes = $this->faker->randomElements($sizeValues, $this->faker->numberBetween(2, 4));

                // Create size entries for this variant
                foreach ($availableSizes as $sizeValue) {
                    $basePrice = $this->faker->numberBetween(100, 300);
                    
                    VariantSize::create([
                        'variant_id' => $variant->id,
                        'product_option_value_id' => $sizeValue->id,
                        'price' => $basePrice,
                        'sale_price' => $this->faker->optional(0.5)->numberBetween($basePrice * 0.7, $basePrice * 0.9),
                        'stock' => $this->faker->numberBetween(5, 30),
                    ]);
                }
            }
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
