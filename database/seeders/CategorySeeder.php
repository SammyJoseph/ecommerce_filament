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
        $structure = [
            'Hombres' => [
                'Camisas',
                'Polos',
                'Pantalones',
                'Casacas',
            ],
            'Mujeres' => [
                'Vestidos',
                'Blusas',
                'Faldas',
                'Polos',
            ],
            'Niños' => [
                'Polos',
                'Pantalones',
                'Conjuntos',
                'Pijamas',
            ],
            'Bebés' => [
                'Bodies',
                'Enterizos',
                'Mantas',
                'Gorros',
            ],
        ];

        foreach ($structure as $parentName => $children) {
            $parent = Category::create([
                'name'        => $parentName,
                'slug'        => Str::slug($parentName),
                'description' => 'Categoría principal para ' . $parentName,
                'is_visible'  => true,
            ]);

            foreach ($children as $childName) {
                Category::create([
                    'name'        => $childName,
                    'slug'        => Str::slug($childName),
                    'description' => $childName . ' para ' . $parentName,
                    'parent_id'   => $parent->id,
                    'is_visible'  => true,
                ]);
            }
        }
    }
}
