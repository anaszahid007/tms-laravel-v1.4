<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralEarning extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'referral_partner_id',
        'referral_conversion_id',
        'amount',
        'order_amount',
        'status',
    ];

    public function partner()
    {
        return $this->belongsTo(ReferralPartner::class, 'referral_partner_id');
    }

    public function conversion()
    {
        return $this->belongsTo(ReferralConversion::class, 'referral_conversion_id');
    }
}
