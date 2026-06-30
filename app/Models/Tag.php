<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'slug'];

    protected $fillable = ['name', 'slug'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
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
