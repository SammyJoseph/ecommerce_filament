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
            // Create options (Color and Size)
            $colorOption = ProductOption::create([
                'product_id' => $product->id,
                'name' => 'Color',
                'type' => 'color',
            ]);

            $sizeOption = ProductOption::create([
                'product_id' => $product->id,
                'name' => 'Size',
                'type' => 'size',
            ]);

            // Create option values
            $colors = [
                'Red' => '#dc2626',
                'Blue' => '#2563eb',
                'Green' => '#16a34a',
            ];
            $sizes = ['S', 'M', 'L', 'XL'];

            foreach ($colors as $color => $code) {
                ProductOptionValue::create([
                    'product_option_id' => $colorOption->id,
                    'value' => $color,
                    'color_code' => $code,
                ]);
            }

            foreach ($sizes as $size) {
                ProductOptionValue::create([
                    'product_option_id' => $sizeOption->id,
                    'value' => $size,
                ]);
            }

            // All possible combinations (Aliexpress-style availability)
            $allCombinations = [
                ['Color' => 'Red', 'Size' => 'M'],
                ['Color' => 'Red', 'Size' => 'L'],
                ['Color' => 'Blue', 'Size' => 'L'],
                ['Color' => 'Blue', 'Size' => 'XL'],
                ['Color' => 'Green', 'Size' => 'S'],
            ];

            // Randomly select 1-5 combinations for this product
            $numVariants = fake()->numberBetween(1, 5);
            $selectedCombinations = fake()->randomElements($allCombinations, $numVariants);

            // Group combinations by color for new structure
            $colorGroups = [];
            foreach ($selectedCombinations as $combo) {
                $colorGroups[$combo['Color']][] = $combo['Size'];
            }

            // Create one variant per color
            foreach ($colorGroups as $colorName => $sizes) {
                $colorValue = ProductOptionValue::where('product_option_id', $colorOption->id)
                    ->where('value', $colorName)
                    ->first();

                if (!$colorValue) continue;

                $variant = Variant::factory()->create([
                    'product_id' => $product->id,
                    'color_id' => $colorValue->id,
                    'sku' => fake()->unique()->ean13(),
                    'is_visible' => true,
                ]);

                // Create variant sizes for each size in this color
                foreach ($sizes as $sizeName) {
                    $sizeValue = ProductOptionValue::where('product_option_id', $sizeOption->id)
                        ->where('value', $sizeName)
                        ->first();

                    if ($sizeValue) {
                        $price = fake()->numberBetween(70, 200);
                        \App\Models\VariantSize::create([
                            'variant_id' => $variant->id,
                            'product_option_value_id' => $sizeValue->id,
                            'price' => $price,
                            'sale_price' => fake()->optional(0.5)->numberBetween($price * 0.7, $price * 0.9),
                            'stock' => fake()->numberBetween(5, 20),
                        ]);
                    }
                }
            }
        });
    }

    public function fromManualData(array $data, string $basePath): static
    {
        return $this->state(function (array $attributes) use ($data) {
            return [
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => 0, // Stock will be sum of variants
                'is_visible' => true,
                'is_featured' => false,
            ];
        })->afterCreating(function (Product $product) use ($data, $basePath) {
            // Handle Additional Product Images (General/Gallery)
            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $image) {
                    $imagePath = $basePath . '/' . $image;
                    if (file_exists($imagePath)) {
                        $product->addMedia($imagePath)
                            ->preservingOriginal()
                            ->toMediaCollection('product_images');
                    } else {
                        Log::warning("Additional image not found: $imagePath");
                    }
                }
            }

            // Create options
            $colorOption = ProductOption::create([
                'product_id' => $product->id,
                'name' => 'Color',
                'type' => 'color',
            ]);

            $sizeOption = ProductOption::create([
                'product_id' => $product->id,
                'name' => 'Size',
                'type' => 'size',
            ]);

            // Track total stock
            $totalStock = 0;

            foreach ($data['variants'] as $variantData) {
                // Find or create color value
                // In manual data, we assume color names are unique per product context or global? 
                // ProductOptionValue is per ProductOption, so per product.
                $colorValue = ProductOptionValue::create([
                    'product_option_id' => $colorOption->id,
                    'value' => $variantData['color'],
                    'color_code' => $variantData['hex'] ?? $variantData['color_code'] ?? '#000000',
                ]);

                // Create Variant
                $variant = Variant::create([
                    'product_id' => $product->id,
                    'color_id' => $colorValue->id,
                    'sku' => $variantData['sku'],
                    'is_visible' => true,
                ]);

                // Handle Image
                if (isset($variantData['image'])) {
                    $imagePath = $basePath . '/' . $variantData['image'];
                    if (file_exists($imagePath)) {
                        // Add to Variant
                        $variant->addMedia($imagePath)
                            ->preservingOriginal()
                            ->toMediaCollection('variant_images');
                            
                        // Add to Product (Main Gallery)
                        $product->addMedia($imagePath)
                            ->preservingOriginal()
                            ->toMediaCollection('product_images');
                    } else {
                        Log::warning("Image not found: $imagePath");
                    }
                }

                // Handle Sizes
                foreach ($variantData['sizes'] as $sizeData) {
                    // Find or create size value
                    // Check if size value already exists for this option
                    $sizeValue = ProductOptionValue::firstOrCreate([
                        'product_option_id' => $sizeOption->id,
                        'value' => $sizeData['size'],
                    ]);

                    \App\Models\VariantSize::create([
                        'variant_id' => $variant->id,
                        'product_option_value_id' => $sizeValue->id,
                        'price' => $sizeData['price'] ?? $data['price'],
                        'sale_price' => null,
                        'stock' => $sizeData['stock'],
                    ]);

                    $totalStock += $sizeData['stock'];
                }
            }

            $product->update(['stock' => $totalStock]);
        });
    }

    public function withRandomImages(): static
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

    public function configure(): static
    {
        return $this;
    }
}
