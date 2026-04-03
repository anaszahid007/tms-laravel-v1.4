<?php

namespace App\Models;

use App\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use BelongsToShop, HasFactory, HasUuids;

    protected $fillable = [
        'shop_id', 'customer_id', 'order_key', 'status',
        'start_date', 'delivery_date', 'total_price', 'advance_payment', 'remaining_amount', 'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'delivery_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
