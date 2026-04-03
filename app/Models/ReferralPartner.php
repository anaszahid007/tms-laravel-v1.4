<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralPartner extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'referral_code',
        'commission_type',
        'commission_value',
        'duration_type',
        'duration_limit',
        'status',
    ];

    public function conversions()
    {
        return $this->hasMany(ReferralConversion::class);
    }

    public function earnings()
    {
        return $this->hasMany(ReferralEarning::class);
    }

    public function payouts()
    {
        return $this->hasMany(ReferralPayout::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
