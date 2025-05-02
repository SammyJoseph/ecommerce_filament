<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'is_visible',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->performOnCollections('product_images') // nombre de la colección de imágenes
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->keepOriginalImageFormat()
            ->nonQueued(); // Procesa inmediatamente

        $this->addMediaConversion('preview')
            ->performOnCollections('product_images')
            ->width(600)
            ->height(600)
            ->keepOriginalImageFormat()
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')
            ->singleFile(); // Si solo quieres una imagen por producto
    }
}
