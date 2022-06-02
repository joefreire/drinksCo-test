<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id', 'product_id', 'quantity','total'
    ];
    /**
     * Get the Items for the cart.
     */
    public function cart()
    {
        return $this->hasOne('App\Models\Cart');
    }
    /**
     * Get the Product for the cart item.
     */
    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
}
