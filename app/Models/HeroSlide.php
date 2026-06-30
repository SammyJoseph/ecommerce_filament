<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;

class HeroSlide extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    public $translatable = ['title', 'subtitle', 'description', 'button_text'];

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
        'is_active',
        'sort_order',
        'button_bg_color',
        'button_hover_bg_color',
        'button_text_color',
        'button_hover_text_color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order');
    }
}
