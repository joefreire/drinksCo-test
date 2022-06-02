<?php

namespace App\Observers;

/**
 * Lumen doesn't register observers like laravel, so I created this trait to make it simpler
 */
trait CartObserver
{
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($cart) {
            $cart->cartItems()->delete();
        });
    }
}
