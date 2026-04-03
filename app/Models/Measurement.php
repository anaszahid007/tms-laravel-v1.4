<?php

namespace App\Models;

use App\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Measurement extends Model
{
    use HasFactory, BelongsToShop, HasUuids;

    protected $fillable = [
        'shop_id', 
        'customer_id', 
        'measurement_key',
        'data', 
        'type', 
        'notes',
        'template_id',
        'language'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($measurement) {
            // Logic to generate a sequential key per shop
            // We use DB::table to avoid global scopes interference during generation
            $latest = DB::table('measurements')
                ->where('shop_id', $measurement->shop_id)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$latest) {
                $nextNumber = 1;
            } else {
                // Extracts digits from 'MEAS-0001' to increment
                $lastNumber = (int) preg_replace('/[^0-9]/', '', $latest->measurement_key);
                $nextNumber = $lastNumber + 1;
            }

            $measurement->measurement_key = 'M-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(MeasurementTemplate::class);
    }

    public function getDisplayLanguage(): string
    {
        return $this->language ?? 'en';
    }
}
