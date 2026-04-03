<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'visit_id',
        'url',
        'action',
        'model_type',
        'model_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
