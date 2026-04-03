<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'shop_key',
        'subscription_ends_at',
        'status',
        'phone',
        'address',
        'is_suspended',
        'customers_public',
        'referral_partner_id',
        'referral_commission_count',
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shop) {
            if (empty($shop->shop_key)) {
                $shop->shop_key = 'SHOP-'.strtoupper(\Illuminate\Support\Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(ShopSubscription::class);
    }

    public function currentSubscription()
    {
        return $this->subscriptions()
                    ->active()
                    ->latest()
                    ->first();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->currentSubscription() !== null;
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function partner()
    {
        return $this->belongsTo(ReferralPartner::class, 'referral_partner_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the accurate display status by reconciling legacy status and new subscriptions.
     */
    public function getDisplayStatusAttribute(): string
    {
        // 1. Check for active/grace subscription in new system
        $current = $this->currentSubscription();
        if ($current) {
            return $current->status; // 'active'
        }

        // 2. Check for temporary grace access (pending payment)
        $grace = $this->subscriptions()
            ->where('status', 'grace')
            ->where('is_active', true)
            ->where('grace_period_ends_at', '>', now())
            ->latest()
            ->first();

        if ($grace) {
            return 'grace';
        }

        // 3. If no active/grace in new system, check if there's an expired record
        $latest = $this->subscriptions()->latest()->first();
        if ($latest && $latest->status === 'expired') {
            return 'expired';
        }

        // 4. Fallback to legacy status (for Trial shops that haven't subscribed yet)
        if ($this->status === 'trial' && $this->subscription_ends_at && $this->subscription_ends_at->isPast()) {
            return 'expired';
        }

        return $this->status;
    }
}
