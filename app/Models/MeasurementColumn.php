<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasurementColumn extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'template_id',
        'field_name',
        'label',
        'label_urdu',
        'unit',
        'sort_order',
        'is_required',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(MeasurementTemplate::class);
    }

    public function getDisplayLabel(string $language = 'en'): string
    {
        if ($language === 'ur' && $this->label_urdu) {
            return $this->label_urdu;
        }
        return $this->label;
    }

    public function getFullLabel(string $language = 'en'): string
    {
        $label = $this->getDisplayLabel($language);
        return $this->unit ? "{$label} ({$this->unit})" : $label;
    }
}