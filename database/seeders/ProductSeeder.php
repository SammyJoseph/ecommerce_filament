<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $manualProducts = $this->loadManualProducts();

        foreach ($categories as $category) {
            // Create 4 products for each category
            for ($i = 0; $i < 4; $i++) {
                
                // Check if we have a manual product for this category
                $manualIndex = null;
                foreach ($manualProducts as $index => $mp) {
                    if (in_array($category->name, $mp['data']['categories'] ?? [])) {
                        $manualIndex = $index;
                        break;
                    }
                }

                if ($manualIndex !== null) {
                    $mp = $manualProducts[$manualIndex];
                    
                    Product::factory()
                        ->fromManualData($mp['data'], $mp['path'])
                        ->create(['category_id' => $category->id]);

                    // Remove used manual product to avoid duplicates
                    unset($manualProducts[$manualIndex]);
                } else {
                    $factory = Product::factory()->state(['category_id' => $category->id]);

                    // Randomly decide if this product should have variants (50% chance)
                    if (fake()->boolean(50)) {
                        $factory = $factory->withVariants();
                    }

                    $factory->withRandomImages()->create();
                }
            }
        }
    }

    protected function loadManualProducts(): array
    {
        $path = database_path('seeders/data/products');
        if (!\Illuminate\Support\Facades\File::isDirectory($path)) {
            return [];
        }

        $products = [];
        $directories = \Illuminate\Support\Facades\File::directories($path);

        foreach ($directories as $dir) {
            $infoFile = $dir . '/info.json';
            if (\Illuminate\Support\Facades\File::exists($infoFile)) {
                $data = json_decode(\Illuminate\Support\Facades\File::get($infoFile), true);
                if ($data) {
                    $products[] = [
                        'data' => $data,
                        'path' => $dir
                    ];
                }
            }
        }

        return $products;
    }
}
