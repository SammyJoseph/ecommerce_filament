<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [

        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'is_visible',
        'is_featured',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(ProductOption::class);
    }

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
    
    public function getHasVariantsAttribute(): bool
    {
        return $this->variants()->exists();
    }

    public function getMinVariantPriceAttribute()
    {
        return VariantSize::whereHas('variant', function ($query) {
            $query->where('product_id', $this->id)
                  ->where('is_visible', true);
        })->get()->map(function ($variantSize) {
            return ($variantSize->sale_price > 0) ? $variantSize->sale_price : $variantSize->price;
        })->min();
    }

    /**
     * Get valid combinations of options for this product
     * Returns array with colors, sizes, and their valid combinations with stock
     */
    public function getVariantCombinations()
    {
        $combinations = [
            'colors' => [],
            'sizes' => [],
            'combinations' => []
        ];

        // Get all visible variants with their color and sizes
        $variants = $this->variants()
            ->where('is_visible', true)
            ->with(['color', 'sizes.size'])
            ->get();

        if ($variants->isEmpty()) {
            return $combinations;
        }

        foreach ($variants as $variant) {
            if (!$variant->color) {
                continue;
            }

            $colorValue = $variant->color->value;
            $colorCode = $variant->color->color_code ?? '#ccc';

            // Get variant image URLs
            $variantImage = null;
            $variantThumb = null;
            $variantOriginal = null;
            if ($variant->getFirstMedia('variant_images')) {
                $variantImage = $variant->getFirstMediaUrl('variant_images', 'preview');
                $variantThumb = $variant->getFirstMediaUrl('variant_images', 'thumb');
                $variantOriginal = $variant->getFirstMediaUrl('variant_images');
            }

            // Add to colors array if not exists
            if (!isset($combinations['colors'][$colorValue])) {
                $combinations['colors'][$colorValue] = [
                    'value' => $colorValue,
                    'color_code' => $colorCode,
                    'available_sizes' => [],
                    'image' => $variantImage,
                    'thumb' => $variantThumb,
                    'original' => $variantOriginal,
                ];
            }

            // Process each size for this color variant
            foreach ($variant->sizes as $variantSize) {
                if (!$variantSize->size) {
                    continue;
                }

                $sizeValue = $variantSize->size->value;
                $combinationKey = $colorValue . '-' . $sizeValue;

                // Add to sizes array if not exists
                if (!isset($combinations['sizes'][$sizeValue])) {
                    $combinations['sizes'][$sizeValue] = [
                        'value' => $sizeValue,
                        'available_colors' => []
                    ];
                }

                // Add combination with stock
                $combinations['combinations'][$combinationKey] = [
                    'color' => $colorValue,
                    'size' => $sizeValue,
                    'stock' => $variantSize->stock,
                    'price' => $variantSize->price,
                    'sale_price' => $variantSize->sale_price,
                    'variant_id' => $variant->id,
                    'variant_size_id' => $variantSize->id,
                    'image' => $variantImage,
                    'thumb' => $variantThumb,
                    'original' => $variantOriginal,
                ];

                // Add size to color's available sizes
                if (!in_array($sizeValue, $combinations['colors'][$colorValue]['available_sizes'])) {
                    $combinations['colors'][$colorValue]['available_sizes'][] = $sizeValue;
                }

                // Add color to size's available colors
                if (!in_array($colorValue, $combinations['sizes'][$sizeValue]['available_colors'])) {
                    $combinations['sizes'][$sizeValue]['available_colors'][] = $colorValue;
                }
            }
        }

        return $combinations;
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
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
}
