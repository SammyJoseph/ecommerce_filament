<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BlogCategoryFactory> */
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'slug', 'description'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
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
