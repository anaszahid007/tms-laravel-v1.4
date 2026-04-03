<?php

namespace App\Models;

use App\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopSubscription extends Model
{
    use HasFactory, BelongsToShop, HasUuids;

    protected $fillable = [
        'shop_id',
        'subscription_plan_id',
        'starts_at',
        'ends_at',
        'grace_period_ends_at',
        'status',
        'is_active',
        'payment_status',
        'payment_proof_path',
        'transaction_id',
        'admin_notes',
        'expiry_notified_at',
        'plan_name',
        'plan_price',
        'plan_duration_days',
        'plan_features',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'grace_period_ends_at' => 'datetime',
        'expiry_notified_at' => 'datetime',
        'is_active' => 'boolean',
        'plan_price' => 'decimal:2',
        'plan_duration_days' => 'integer',
        'plan_features' => 'array',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Check if subscription is currently active
     */
    public function isActive(): bool
    {
        return $this->is_active && 
               $this->status === 'active' && 
               $this->ends_at > now() &&
               $this->starts_at <= now();
    }

    /**
     * Check if subscription is in grace period
     */
    public function isInGracePeriod(): bool
    {
        return $this->status === 'grace' && 
               $this->grace_period_ends_at && 
               $this->grace_period_ends_at > now();
    }

    /**
     * Check if subscription has expired (including grace period)
     */
    public function hasExpired(): bool
    {   
        // if($this-> === 'trail'){
        //     return false
        // }

        if ($this->status === 'expired') {
            return true;
        }

        if ($this->grace_period_ends_at) {
            return $this->grace_period_ends_at <= now();
        }

        return $this->ends_at <= now();
    }

    /**
     * Check if subscription is expiring soon (within 5 days)
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        // Check if expiring within 5 days (120 hours)
        return now()->diffInHours($this->ends_at, false) <= 120;
    }

    /**
     * Activate the subscription
     */
    public function activate(): void
    {
        $this->update([
            'status' => 'active',
            'is_active' => true,
            'payment_status' => 'approved',
        ]);
    }

    /**
     * Put subscription in grace period
     */
    public function enterGracePeriod(): void
    {
        $this->update([
            'status' => 'grace',
            'grace_period_ends_at' => $this->ends_at->copy()->addDays(7),
        ]);
    }

    /**
     * Mark subscription as expired
     */
    public function markAsExpired(): void
    {
        $this->update([
            'status' => 'expired',
            'is_active' => false,
        ]);
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('status', 'active')
                    ->where('ends_at', '>', now())
                    ->where('starts_at', '<=', now());
    }

    /**
     * Scope for expired subscriptions
     */
    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'expired')
              ->orWhere(function ($q2) {
                  $q2->whereNotNull('grace_period_ends_at')
                     ->where('grace_period_ends_at', '<=', now());
              });
        });
    }

    /**
     * Scope for subscriptions expiring soon
     */
    public function scopeExpiringSoon($query)
    {
        return $query->active()
                    ->where('ends_at', '<=', now()->addDays(5));
    }
}