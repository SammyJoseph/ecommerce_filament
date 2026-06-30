<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $translations = [
            'Casual' => 'Casual',
            'Algodón' => 'Coton',
            'Verano' => 'Été',
            'Invierno' => 'Hiver',
            'Deportivo' => 'Sportif',
            'Formal' => 'Formel',
            'Básico' => 'Basique',
            'Tendencia' => 'Tendance',
            'Oferta' => 'Offre',
            'Premium' => 'Premium',
        ];

        $tags = [
            'Casual',
            'Algodón',
            'Verano',
            'Invierno',
            'Deportivo',
            'Formal',
            'Básico',
            'Tendencia',
            'Oferta',
            'Premium',
        ];

        foreach ($tags as $tagName) {
            $frName = $translations[$tagName] ?? $tagName;
            \App\Models\Tag::create([
                'name' => [
                    'es' => $tagName,
                    'fr' => $frName,
                ],
                'slug' => [
                    'es' => \Illuminate\Support\Str::slug($tagName),
                    'fr' => \Illuminate\Support\Str::slug($frName),
                ],
            ]);
        }
    }
}
