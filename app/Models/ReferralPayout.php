<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralPayout extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'referral_partner_id',
        'amount',
        'method',
        'reference_id',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function partner()
    {
        return $this->belongsTo(ReferralPartner::class, 'referral_partner_id');
    }
}
