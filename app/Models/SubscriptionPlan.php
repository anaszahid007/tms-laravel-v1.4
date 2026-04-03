<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'discount_percentage',
        'duration_days',
        'description',
        'features',
        'is_active',
        'is_free',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_percentage' => 'integer',
        'duration_days' => 'integer',
        'is_active' => 'boolean',
        'is_free' => 'boolean',
        'features' => 'array',
    ];

    public function shopSubscriptions()
    {
        return $this->hasMany(ShopSubscription::class);
    }
}
