<?php

namespace App\Services;

use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Exception;

class CartService
{
    private $user;
    private $cart;
    private $cartItems;

    public function __construct($user_id)
    {
        $this->user = User::findOrFail($user_id);
        $this->cart = Cart::getActiveCart($this->user->id);
        $this->cartItems = $this->cart->cartItems();
        if ($this->cartItems->count() >= 10)
            throw new Exception("Itens in the cart can not be more than 10");
    }

    public function addProductCart($product_id, $quantity)
    {
        $product = Product::findOrFail($product_id);
        $productsInCart = $this->cartItems->where('product_id', $product->id);
        if ($productsInCart->count() == 0) {
            $this->cart->cartItems()->create([
                'user_id' => $this->user->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'total' => (float) $quantity * ($quantity >= $product->min_to_sale ? $product->price_sale : $product->price),
            ]);
        } else {
            $productInCart = $productsInCart->first();
            $productInCart->quantity = $quantity;
            $productInCart->total = (float) $quantity * ($quantity >= $product->min_to_sale ? $product->price_sale : $product->price);
            $productInCart->save();
        }
        return $this->cart;
    }

    public function updateProductCart($product_id, $quantity)
    {
        $product = Product::findOrFail($product_id);
        $productsInCart = $this->cartItems->where('product_id', $product->id);
        if ($productsInCart->count() > 0 && $quantity == 0) {
            $productsInCart->delete();
        } else {
            $productInCart = $productsInCart->first();
            $productInCart->quantity = $quantity;
            $productInCart->total = (float) $quantity * ($quantity >= $product->min_to_sale ? $product->price_sale : $product->price);
            $productInCart->save();
        }
        return $this->cart;
    }
    public function removeProductCart($product_id, $cart_id)
    {
        $cart = Cart::with('cartItems')->findOrFail($cart_id);
        $cart = $cart->cartItems()->where('product_id', $product_id)->delete();
        return $cart;
    }
}
