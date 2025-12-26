<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'total_amount',
        'shipping_amount',
        'discount_amount',
        'status',
        'currency',
        'shipping_address_id',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'Pendiente de Pago',
            'payment_confirmed' => 'Pago Confirmado',
            'processing' => 'En Preparación',
            'shipped' => 'En Camino',
            'delivered' => 'Completado',
            'cancelled' => 'Cancelado',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorClassAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'tw-text-gray-700',
            'payment_confirmed' => 'tw-text-blue-600',
            'processing' => 'tw-text-orange-500',
            'shipped' => 'tw-text-orange-500',
            'delivered' => 'tw-text-green-600',
            'cancelled' => 'tw-text-red-600',
            default => 'tw-text-gray-500',
        };
    }

    public function getStatusIconAttribute(): ?string
    {
        return match ($this->status) {
            'pending_payment' => 'heroicon-m-banknotes',
            'payment_confirmed' => 'heroicon-m-check-circle',
            'processing' => 'heroicon-m-arrow-path',
            'shipped' => 'heroicon-m-truck',
            'delivered' => 'heroicon-m-check-badge',
            'cancelled' => 'heroicon-m-x-circle',
            default => null,
        };
    }
}
