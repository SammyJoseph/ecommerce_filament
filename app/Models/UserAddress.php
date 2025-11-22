<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'department',
        'province',
        'district',
        'address',
        'reference',
        'address_type',
        'is_default',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Before creating, validate max 5 addresses per user
        static::creating(function ($address) {
            $count = self::where('user_id', $address->user_id)->count();
            if ($count >= 5) {
                throw new \Exception('Maximum 5 addresses allowed per user');
            }
        });

        // If this address is being set as default, unset other defaults for this user
        static::saving(function ($address) {
            if ($address->is_default) {
                self::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    /**
     * Get the user that owns the address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
