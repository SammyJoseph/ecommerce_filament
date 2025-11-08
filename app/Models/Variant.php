<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Variant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'product_id',
        'color_id',
        'sku',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(VariantSize::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductOptionValue::class, 'color_id');
    }

    // Legacy relationship - kept for backward compatibility
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(ProductOptionValue::class, 'product_variant_options', 'variant_id', 'product_option_value_id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->performOnCollections('variant_images')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->keepOriginalImageFormat()
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->performOnCollections('variant_images')
            ->width(600)
            ->height(600)
            ->keepOriginalImageFormat()
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('variant_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }
}
