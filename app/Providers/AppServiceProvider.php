<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (class_exists(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::class) && class_exists(\Livewire\Livewire::class)) {
            // 1. Cargar Idiomas Dinámicos para el Frontend
            $allLocales = [
                'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'Español', 'regional' => 'es_ES'],
                'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'Français', 'regional' => 'fr_FR'],
                'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
            ];

            $defaultLocale = config('app.locale', 'es');
            $activeCodes = [$defaultLocale];
            try {
                if (app()->bound('db') && \Illuminate\Support\Facades\Schema::hasTable('languages')) {
                    $dbActiveCodes = \App\Models\Language::where('is_active', true)->pluck('code')->toArray();
                    if (!empty($dbActiveCodes)) {
                        $activeCodes = $dbActiveCodes;
                    }
                }
            } catch (\Throwable $e) {}

            if (!in_array($defaultLocale, $activeCodes)) {
                $activeCodes[] = $defaultLocale;
            }

            $supported = array_intersect_key($allLocales, array_flip($activeCodes));
            if (empty($supported)) {
                $supported = [$defaultLocale => $allLocales[$defaultLocale] ?? $allLocales['es']];
            }

            config(['laravellocalization.supportedLocales' => $supported]);

            // 2. Preservar Locale en Peticiones AJAX de Livewire
            \Livewire\Livewire::setUpdateRoute(function ($handle) {
                return \Illuminate\Support\Facades\Route::post('/livewire/update', $handle)
                    ->middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
                    ->prefix(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale());
            });
        }
    }
}
