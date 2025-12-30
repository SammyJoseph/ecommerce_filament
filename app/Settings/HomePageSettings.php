<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HomePageSettings extends Settings
{
    public string $about_us_title;
    public string $about_us_text;
    public string $about_us_image;
    public string $about_us_author;
    public array $banners;
    public string $instagram_title;
    public string $instagram_hashtag;
    public array $instagram_items;
    public array $brand_logos;
    public array $features;

    public static function group(): string
    {
        return 'home_page';
    }
}
