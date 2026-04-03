<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeasurementTemplate extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'type',
        'name',
        'name_urdu',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function columns(): HasMany
    {
        return $this->hasMany(MeasurementColumn::class)->orderBy('sort_order');
    }

    public function activeColumns(): HasMany
    {
        return $this->hasMany(MeasurementColumn::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class);
    }

    public function getDisplayName(string $language = 'en'): string
    {
        if ($language === 'ur' && $this->name_urdu) {
            return $this->name_urdu;
        }

        return $this->name;
    }
}
