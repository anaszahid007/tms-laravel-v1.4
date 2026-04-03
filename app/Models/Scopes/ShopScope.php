<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ShopScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::hasUser() && Auth::user()->shop_id) {
            $builder->where('shop_id', Auth::user()->shop_id);
        }
        // Implicitly: If user has NO shop_id (like Admin), scopes are NOT applied. 
        // This is safe because regular users MUST have a shop_id.
        // But let's be explicit if we want to add future checks:
        // if (Auth::hasUser() && Auth::user()->role === 'admin') { return; }
    }
}
