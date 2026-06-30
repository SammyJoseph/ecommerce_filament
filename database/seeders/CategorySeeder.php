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
        $translations = [
            'Hombres' => 'Hommes',
            'Mujeres' => 'Femmes',
            'Niños' => 'Enfants',
            'Bebés' => 'Bébés',
            'Camisas' => 'Chemises',
            'Polos' => 'Polos',
            'Pantalones' => 'Pantalons',
            'Casacas' => 'Vestes',
            'Vestidos' => 'Robes',
            'Blusas' => 'Blouses',
            'Faldas' => 'Jupes',
            'Conjuntos' => 'Ensembles',
            'Pijamas' => 'Pyjamas',
            'Bodies' => 'Bodys',
            'Enterizos' => 'Combinaisons',
            'Mantas' => 'Couvertures',
            'Gorros' => 'Bonnets',
        ];

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
                'name'        => [
                    'es' => $parentName,
                    'fr' => $translations[$parentName] ?? $parentName,
                ],
                'slug'        => [
                    'es' => Str::slug($parentName),
                    'fr' => Str::slug($translations[$parentName] ?? $parentName),
                ],
                'description' => [
                    'es' => 'Categoría principal para ' . $parentName,
                    'fr' => 'Catégorie principale pour ' . ($translations[$parentName] ?? $parentName),
                ],
                'is_visible'  => true,
            ]);

            foreach ($children as $childName) {
                Category::create([
                    'name'        => [
                        'es' => $childName,
                        'fr' => $translations[$childName] ?? $childName,
                    ],
                    'slug'        => [
                        'es' => Str::slug($childName),
                        'fr' => Str::slug($translations[$childName] ?? $childName),
                    ],
                    'description' => [
                        'es' => $childName . ' para ' . $parentName,
                        'fr' => ($translations[$childName] ?? $childName) . ' pour ' . ($translations[$parentName] ?? $parentName),
                    ],
                    'parent_id'   => $parent->id,
                    'is_visible'  => true,
                ]);
            }
        }
    }
}
