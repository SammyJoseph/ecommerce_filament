<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomePageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Copy images to storage
        $disk = Storage::disk('public');
        $sourceDir = public_path('assets/images');

        // Prepare About Us Image
        $aboutImagePath = 'about-us/logo.png';
        $aboutImageSource = $sourceDir . '/about/logo.png';
        
        if (file_exists($aboutImageSource)) {
            $disk->put($aboutImagePath, file_get_contents($aboutImageSource));
        }

        // Prepare Banner Images
        $banner1Path = 'banners/banner-1.jpg';
        $banner1Source = $sourceDir . '/banner/banner-1.jpg';
        if (file_exists($banner1Source)) {
            $disk->put($banner1Path, file_get_contents($banner1Source));
        }

        $banner2Path = 'banners/banner-2.jpg';
        $banner2Source = $sourceDir . '/banner/banner-2.jpg';
        if (file_exists($banner2Source)) {
            $disk->put($banner2Path, file_get_contents($banner2Source));
        }

        $banners = [
            [
                'title' => 'Zara Pattern Boxed Underwear',
                'description' => 'Stretch, fresh-cool help you alway comfortable',
                'image' => $banner1Path,
                'link' => '#',
                'text_color' => '',
            ],
            [
                'title' => 'Basic Color Caps',
                'description' => 'Minimalist never cool, choose and make the simple great again!',
                'image' => $banner2Path,
                'link' => '#',
                'text_color' => '',
            ]
        ];

        // Prepare Instagram Images
        $instagramItems = [];
        for ($i = 1; $i <= 5; $i++) {
            $instagramPath = "instagram/{$i}.jpg";
            $instagramSource = $sourceDir . "/instagram/{$i}.jpg";
            if (file_exists($instagramSource)) {
                $disk->put($instagramPath, file_get_contents($instagramSource));
                $instagramItems[] = [
                    'image' => $instagramPath,
                    'link' => '#',
                ];
            }
        }

        // Prepare Brand Logos
        $brandLogos = [];
        for ($i = 1; $i <= 5; $i++) {
            $brandLogoPath = "brands/brand-logo-{$i}.png";
            $brandLogoSource = $sourceDir . "/brand-logo/brand-logo-{$i}.png";
            if (file_exists($brandLogoSource)) {
                $disk->put($brandLogoPath, file_get_contents($brandLogoSource));
                $brandLogos[] = [
                    'image' => $brandLogoPath,
                ];
            }
        }

        DB::table('settings')->insertOrIgnore([
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
                'payload' => json_encode($aboutImagePath),
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
            [
                'group' => 'home_page',
                'name' => 'instagram_title',
                'locked' => 0,
                'payload' => json_encode('Our Instagram'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'instagram_hashtag',
                'locked' => 0,
                'payload' => json_encode('#monkeylover'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'instagram_items',
                'locked' => 0,
                'payload' => json_encode($instagramItems),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'brand_logos',
                'locked' => 0,
                'payload' => json_encode($brandLogos),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'features',
                'locked' => 0,
                'payload' => json_encode([
                    [
                        'icon' => 'icon-cursor',
                        'title' => 'Free Shipping',
                        'subtitle' => 'Orders over $100',
                    ],
                    [
                        'icon' => 'icon-reload',
                        'title' => 'Free Returns',
                        'subtitle' => 'Within 30 days',
                    ],
                    [
                        'icon' => 'icon-lock',
                        'title' => '100% Secure',
                        'subtitle' => 'Payment Online',
                    ],
                    [
                        'icon' => 'icon-tag',
                        'title' => 'Best Price',
                        'subtitle' => 'Guaranteed',
                    ],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
