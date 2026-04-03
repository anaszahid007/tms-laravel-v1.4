<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'referer',
        'city',
        'region',
        'country',
    ];

    public function activities()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function getLocationNameAttribute()
    {
        $parts = [];
        if (!empty($this->city)) $parts[] = $this->city;
        if (!empty($this->region)) $parts[] = $this->region;
        
        if (!empty($parts)) {
            return implode(' - ', $parts);
        }
        
        return $this->country ?? 'Unknown Location';
    }
}
