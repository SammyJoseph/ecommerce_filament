<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::create([
            'code' => 'es',
            'name' => 'Español',
            'is_active' => true,
        ]);

        Language::create([
            'code' => 'fr',
            'name' => 'Français',
            'is_active' => true,
        ]);

        Language::create([
            'code' => 'en',
            'name' => 'English',
            'is_active' => false,
        ]);
    }
}
