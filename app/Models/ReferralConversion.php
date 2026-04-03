<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralConversion extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'referral_partner_id',
        'shop_id',
        'converted_at',
    ];

    protected $casts = [
        'converted_at' => 'datetime',
    ];

    public function partner()
    {
        return $this->belongsTo(ReferralPartner::class, 'referral_partner_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
