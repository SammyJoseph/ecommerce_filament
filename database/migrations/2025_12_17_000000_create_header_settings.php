<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('header.top_message_text', 'ENVÍO GRATIS para compras mayores a');
        $this->migrator->add('header.top_message_amount', 'S/199');
        $this->migrator->add('header.track_order_text', 'Rastrea tu pedido');
        $this->migrator->add('header.track_order_url', '#');
        $this->migrator->add('header.languages', [
            ['name' => 'Español', 'url' => '#'],
            ['name' => 'English', 'url' => '#'],
            ['name' => 'Français', 'url' => '#'],
        ]);
        $this->migrator->add('header.currencies', [
            ['name' => 'PEN', 'url' => '#'],
            ['name' => 'USD', 'url' => '#'],
            ['name' => 'EUR', 'url' => '#'],
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
