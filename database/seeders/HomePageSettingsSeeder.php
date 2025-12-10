<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Zara Pattern Boxed <br>Underwear',
                'description' => 'Stretch, fresh-cool help you alway comfortable',
                'image' => 'assets/images/banner/banner-1.jpg',
                'link' => 'product-details.html',
                'text_color' => '',
            ],
            [
                'title' => 'Basic Color Caps',
                'description' => 'Minimalist never cool, choose and make the simple great again!',
                'image' => 'assets/images/banner/banner-2.jpg',
                'link' => 'product-details.html',
                'text_color' => '',
            ]
        ];

        DB::table('settings')->insert([
            [
                'group' => 'home_page',
                'name' => 'about_us_title',
                'locked' => 0,
                'payload' => json_encode('Introduce'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'about_us_text',
                'locked' => 0,
                'payload' => json_encode('Norda store is a business concept is to offer fashion and quality at the best price. It has since it was founded in 2022 grown into one of the best WooCommerce Fashion Theme. The content of this site is copyright-protected and is the property of David Moye Creative.'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'about_us_image',
                'locked' => 0,
                'payload' => json_encode('assets/images/about/logo.png'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'about_us_author',
                'locked' => 0,
                'payload' => json_encode('David Moye'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'banners',
                'locked' => 0,
                'payload' => json_encode($banners),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
