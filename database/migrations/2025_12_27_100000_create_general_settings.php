<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Norda');
        $this->migrator->add('general.site_logo', null);
        $this->migrator->add('general.site_favicon', null);
        $this->migrator->add('general.meta_description', 'Norda - Minimalist eCommerce Store');
        $this->migrator->add('general.contact_phone', '(+51) 987654321');
        $this->migrator->add('general.contact_address', 'Av. Lima 123, Perú');
        $this->migrator->add('general.copyright_text', 'Desarrollado por Artisam Web');

        $this->migrator->add('general.main_background_color', '#f0f4f6');
        $this->migrator->add('general.secondary_color', '#ffffff');
        $this->migrator->add('general.fonts', [
            [
                'name' => 'Heebo',
                'embed_code' => '<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">'
            ]
        ]);
        $this->migrator->add('general.h1_font_family', 'Heebo');
    }
};
