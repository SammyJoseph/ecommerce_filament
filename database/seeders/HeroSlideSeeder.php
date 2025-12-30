<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Moda esencial para cada día',
                'subtitle' => 'Nueva colección',
                'description' => 'Descubre polos, camisas y pantalones diseñados para combinar comodidad, estilo y calidad en cada ocasión.',
                'button_text' => 'Ver colección',
                'button_link' => '#',
                'sort_order' => 1,
                'is_active' => true,
                'image_path' => public_path('assets/images/slider/hm-1-slider-1.png'),
            ],
            [
                'title' => 'Estilo que se adapta a ti',
                'subtitle' => 'Lo último en tendencias',
                'description' => 'Prendas versátiles y modernas que elevan tu look, perfectas para el día a día o momentos especiales.',
                'button_text' => 'Descubrir ahora',
                'button_link' => '#',
                'sort_order' => 2,
                'is_active' => true,
                'image_path' => public_path('assets/images/slider/hm-1-slider-4.png'),
            ],
        ];

        foreach ($slides as $data) {
            $imagePath = $data['image_path'];
            unset($data['image_path']);

            $slide = HeroSlide::create($data);

            if (file_exists($imagePath)) {
                $slide->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('hero_slides');
            }
        }
    }
}
