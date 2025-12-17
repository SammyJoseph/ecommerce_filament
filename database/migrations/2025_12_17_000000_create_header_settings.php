<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('header.top_message_text', 'FREE SHIPPING world wide for all orders over');
        $this->migrator->add('header.top_message_amount', '$199');
        $this->migrator->add('header.track_order_text', 'Track Your Order');
        $this->migrator->add('header.track_order_url', 'order-tracking.html');
        $this->migrator->add('header.languages', [
            ['name' => 'English', 'url' => '#'],
            ['name' => 'French', 'url' => '#'],
            ['name' => 'German', 'url' => '#'],
            ['name' => 'Spanish', 'url' => '#'],
        ]);
        $this->migrator->add('header.currencies', [
            ['name' => 'USD', 'url' => '#'],
            ['name' => 'EUR', 'url' => '#'],
            ['name' => 'Real', 'url' => '#'],
            ['name' => 'BDT', 'url' => '#'],
        ]);
        $this->migrator->add('header.social_links', [
            ['icon' => 'icon-social-twitter', 'url' => '#'],
            ['icon' => 'icon-social-facebook', 'url' => '#'],
            ['icon' => 'icon-social-instagram', 'url' => '#'],
            ['icon' => 'icon-social-youtube', 'url' => '#'],
            ['icon' => 'icon-social-pinterest', 'url' => '#'],
        ]);
    }
};
