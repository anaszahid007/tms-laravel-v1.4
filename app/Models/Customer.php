<?php

namespace App\Models;

use App\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, BelongsToShop, HasUuids;

    protected $fillable = ['shop_id', 'customer_key', 'name', 'father_name', 'phone', 'address', 'gender'];

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
