<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'          => 'Casacas',
                'description'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'is_visible'    => true,
            ],
            [
                'name'          => 'Polos',
                'description'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'is_visible'    => true,
            ],
            [
                'name'          => 'Hombres',
                'description'   => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_visible'    => true,
            ],
            [
                'name'          => 'Mujeres',
                'description'   => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
                'is_visible'    => true,
            ],
            [
                'name'          => 'Niños',
                'description'   => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.',
                'is_visible'    => true,
            ],
        ];

        foreach ($categories as $category) {
            $category['slug'] = Str::slug($category['name']);
            Category::create($category);
        }
    }
}
