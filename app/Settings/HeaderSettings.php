<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HeaderSettings extends Settings
{
    public string $top_message_text;
    public string $top_message_amount;
    public string $track_order_text;
    public string $track_order_url;
    public array $languages;
    public array $currencies;
    public array $social_links;

    public static function group(): string
    {
        return 'header';
    }
}
