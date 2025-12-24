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

        // 1. Process Manual Products
        foreach ($manualProducts as $mp) {
            $data = $mp['data'];
            
            // Create Product
            $product = Product::factory()
                ->fromManualData($data, $mp['path'])
                ->create(); // category_id is removed from fillable, so we don't pass it here

            // Attach Categories
            if (isset($data['categories']) && is_array($data['categories'])) {
                $categoryIds = Category::whereIn('name', $data['categories'])->pluck('id');
                $product->categories()->attach($categoryIds);
            }
        }

        // 2. Create Random Products for Categories
        // We ensure each category has at least a few products, mimicking previous logic but adapted
        foreach ($categories as $category) {
            // Check if category already has enough products (from manual load)
            if ($category->products()->count() >= 4) {
                continue;
            }

            // Create remaining needed products
            $productsToCreate = 4 - $category->products()->count();

            for ($i = 0; $i < $productsToCreate; $i++) {
                $factory = Product::factory();

                // Randomly decide if this product should have variants (50% chance)
                if (fake()->boolean(50)) {
                    $factory = $factory->withVariants();
                }

                $product = $factory->withRandomImages()->create();
                
                // Attach main category and maybe random others
                $product->categories()->attach($category->id);
                
                // Optionally attach 1-2 random other categories
                if (fake()->boolean(30)) {
                    $otherCategories = $categories->where('id', '!=', $category->id)->random(min(2, $categories->count() - 1));
                    $product->categories()->attach($otherCategories->pluck('id'));
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
