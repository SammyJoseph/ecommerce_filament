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
            \App\Models\Tag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($tagName)],
                ['name' => $tagName]
            );
        }
    }
}
