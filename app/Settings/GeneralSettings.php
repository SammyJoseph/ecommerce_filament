<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public ?string $site_logo;
    public ?string $site_favicon;
    public ?string $meta_description;
    public string $contact_phone;
    public string $contact_address;
    public string $copyright_text;

    public string $main_background_color;
    public string $secondary_color;
    public array $fonts;
    public string $h1_font_family;

    public static function group(): string
    {
        return 'general';
    }
}
