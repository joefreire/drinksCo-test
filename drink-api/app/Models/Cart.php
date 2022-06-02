<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CartObserver;

class Cart extends Model
{
    use CartObserver;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'paid', 'total', 'total_with_sale'
    ];
    /**
     * Get the Items for the cart.
     */
    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem');
    }
    /**
     * Get Active Cart From User
     */
    public static function getActiveCart($user_id)
    {
        return self::with('cartItems')->firstOrCreate([
            'user_id' => $user_id,
            'paid' => 0
        ]);
    }
    /**
     * Get Total of Cart
     */
    public function getTotal()
    {
        return $this->cartItems->sum('total');
    }
}
