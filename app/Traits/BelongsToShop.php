<?php

namespace App\Traits;

use App\Models\Scopes\ShopScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait BelongsToShop
{
    protected static function bootBelongsToShop(): void
    {
        static::addGlobalScope(new ShopScope);

        static::creating(function (Model $model) {
            if (Auth::hasUser() && Auth::user()->shop_id) {
                $model->shop_id = Auth::user()->shop_id;
            }
        });
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }
}
