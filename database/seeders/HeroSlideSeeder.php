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
                'title' => 'Leather Simple Backpacks',
                'subtitle' => 'New Arrivals',
                'description' => 'Discover our collection with leather simple backpacks. Less is more never out trend.',
                'button_text' => 'Explore Now',
                'button_link' => '#',
                'sort_order' => 1,
                'is_active' => true,
                'image_path' => public_path('assets/images/slider/hm-1-slider-1.png'),
            ],
            [
                'title' => 'Leather Simple Backpacks',
                'subtitle' => 'New Arrivals',
                'description' => 'Discover our collection with leather simple backpacks. Less is more never out trend.',
                'button_text' => 'Explore Now',
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
