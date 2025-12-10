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

        // Create 12 products
        for ($i = 0; $i < 12; $i++) {
            $factory = Product::factory();

            if ($categories->count() > 0) {
                $factory = $factory->state(['category_id' => $categories->random()->id]);
            }

            // Randomly decide if this product should have variants (60% chance)
            if (fake()->boolean(60)) {
                $factory = $factory->withVariants();
            }

            $factory->create();
        }
    }
}
