<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Variant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'sale_price',
        'stock',
        'is_visible',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_visible' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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
            ->singleFile();
    }
}
