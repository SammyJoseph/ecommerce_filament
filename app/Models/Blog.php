<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, HasTranslations;

    public $translatable = ['title', 'slug', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_visible',
        'published_at',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true)
            ->whereDate('published_at', '<=', now());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $field = $field ?? $this->getRouteKeyName();
        
        if ($field === 'slug' && method_exists($this, 'getTranslatableAttributes') && in_array('slug', $this->getTranslatableAttributes())) {
            $locale = app()->getLocale();
            return $this->where("slug->{$locale}", $value)
                ->orWhere("slug->es", $value)
                ->first() ?? parent::resolveRouteBinding($value, $field);
        }

        return parent::resolveRouteBinding($value, $field);
    }
}
