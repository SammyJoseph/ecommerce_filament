<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\Variant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $diskName = config('media-library.disk_name');
        $prefix = config('media-library.prefix');
        $this->command->warn("Clearing Spatie media directories from disk: '{$diskName}' in '{$prefix}'");

        try {
            $disk = Storage::disk($diskName);
            $path = $prefix ? $prefix : ''; // Obtiene los directorios dentro del prefijo configurado
            $directories = $disk->directories($path);

            $deletedCount = 0;
            foreach ($directories as $directory) {
                $dirname = basename($directory);
                if (is_numeric($dirname)) { // Solo borra los directorios que estén dentro del prefijo y sean numéricos (id de los modelos)
                    $disk->deleteDirectory($directory);
                    $deletedCount++;
                }
            }
            $this->command->info("Deleted {$deletedCount} media directories from {$prefix}.");

        } catch (\InvalidArgumentException $e) {
            $this->command->error("Error accessing disk '{$diskName}'. Check config/filesystems.php and config/media-library.php. Error: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->command->error("An unexpected error occurred while deleting media directories: " . $e->getMessage());
        }

        $this->call(RolesPermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);

        // Create products with variants (Aliexpress-style)
        $this->createProductsWithVariants();

        $this->call(CouponSeeder::class);
        $this->call(OrderSeeder::class);
    }

    private function createProductsWithVariants()
    {
        $categories = Category::all();

        // Create 10 products with random variant assignment
        for ($i = 0; $i < 10; $i++) {
            $product = Product::factory()->create([
                'category_id' => $categories->random()->id,
            ]);

            // Randomly decide if this product should have variants (60% chance)
            if (fake()->boolean(60)) {
                $this->addVariantsToProduct($product);
            }
        }
    }

    private function addVariantsToProduct(Product $product)
    {
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
    }
}
