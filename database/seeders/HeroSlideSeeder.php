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
                'title' => [
                    'es' => 'Moda esencial para cada día',
                    'fr' => 'Mode essentielle pour chaque jour',
                ],
                'subtitle' => [
                    'es' => 'Nueva colección',
                    'fr' => 'Nouvelle collection',
                ],
                'description' => [
                    'es' => 'Descubre polos, camisas y pantalones diseñados para combinar comodidad, estilo y calidad en cada ocasión.',
                    'fr' => 'Découvrez des polos, des chemises et des pantalons conçus pour allier confort, style et qualité en toutes occasions.',
                ],
                'button_text' => [
                    'es' => 'Ver colección',
                    'fr' => 'Voir la collection',
                ],
                'button_link' => '#',
                'sort_order' => 1,
                'is_active' => true,
                'button_bg_color' => '#000000',
                'button_hover_bg_color' => '#ff2f2f',
                'button_text_color' => '#ffffff',
                'button_hover_text_color' => '#ffffff',
                'image_path' => public_path('assets/images/slider/hm-1-slider-1.png'),
            ],
            [
                'title' => [
                    'es' => 'Estilo que se adapta a ti',
                    'fr' => 'Un style qui s\'adapte à vous',
                ],
                'subtitle' => [
                    'es' => 'Lo último en tendencias',
                    'fr' => 'Les dernières tendances',
                ],
                'description' => [
                    'es' => 'Prendas versátiles y modernas que elevan tu look, perfectas para el día a día o momentos especiales.',
                    'fr' => 'Des vêtements polyvalents et modernes qui rehaussent votre look, parfaits pour le quotidien ou les moments spéciaux.',
                ],
                'button_text' => [
                    'es' => 'Descubrir ahora',
                    'fr' => 'Découvrir maintenant',
                ],
                'button_link' => '#',
                'sort_order' => 2,
                'is_active' => true,
                'button_bg_color' => '#000000',
                'button_hover_bg_color' => '#ff2f2f',
                'button_text_color' => '#ffffff',
                'button_hover_text_color' => '#ffffff',
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
