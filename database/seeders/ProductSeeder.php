<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some products with variants (60% chance)
        Product::factory(20)->create();

        // Ensure we have at least a few products with color options for testing
        Product::factory(5)->withVariants()->create();
    }
}
