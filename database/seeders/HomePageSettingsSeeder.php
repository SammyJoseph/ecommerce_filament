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
                'title' => 'Bolso de tela grande',
                'description' => 'Diseño versátil y moderno, perfecto para acompañarte en cada ocasión.',
                'image' => $banner1Path,
                'link' => '#',
                'text_color' => '',
            ],
            [
                'title' => 'Gorros urbanos para hombre',
                'description' => 'Comodidad y actitud en cada detalle, ideales para completar tu look casual.',
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
                'payload' => json_encode('Nosotros'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'about_us_text',
                'locked' => 0,
                'payload' => json_encode('Norda store es un concepto empresarial que ofrece moda y calidad al mejor precio. Ha crecido desde su fundación en 2022 hasta convertirse en uno de los mejores WooCommerce Fashion Theme. El contenido de este sitio es protegido por derechos de autor y es la propiedad de David Moye Creative.'),
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
                'payload' => json_encode('Instagram'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'home_page',
                'name' => 'instagram_hashtag',
                'locked' => 0,
                'payload' => json_encode('#tendencias'),
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
                        'title' => 'Envío Gratuito',
                        'subtitle' => 'Compras sobre S/199',
                    ],
                    [
                        'icon' => 'icon-reload',
                        'title' => 'Reembolsos',
                        'subtitle' => 'Dentro de 30 días',
                    ],
                    [
                        'icon' => 'icon-lock',
                        'title' => '100% Seguro',
                        'subtitle' => 'Pagos Online',
                    ],
                    [
                        'icon' => 'icon-tag',
                        'title' => 'Mejor Precio',
                        'subtitle' => 'Garantizado',
                    ],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
