<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class CartTest extends TestCase
{
    public $user;
    public $product;
    public $cart;
    public function data()
    {
        $user = User::where('email', 'test@json.com')->first();
        if (empty($user)) {
            $response = $this->call('POST', '/register', ['username' => 'TestCart', 'email' => 'test@json.com', 'password' => 'teste1234']);
            $this->assertEquals(200, $response->status());
            $user = User::where('email', 'test@json.com')->first();
        }
        $this->user = $user;
        $product = Product::inRandomOrder()->first();
        if (empty($product)) {
            $product = $this->createProduct();
        }
        $this->product = $product;
        $this->cart = Cart::getActiveCart($user->id);
    }
    public function createProduct()
    {
        $rand = rand();
        $price = rand(2, 30);
        $response = $this->call('POST', 'product/', [
            'title' => 'TestPHPUnit Product ' . $rand,
            'price' => $price,
            'price_sale' => ($price * 0.9),
            'min_to_sale' => rand(2, 10)
        ]);

        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('products', ['title' => 'TestPHPUnit Product ' . $rand]);
        return Product::where(['title' => 'TestPHPUnit Product ' . $rand])->first();
    }
    public function testClearProductsCart()
    {
        $this->data();
        $response = $this->call('GET', 'cart/remove-all-products/' . $this->user->id);
        $this->assertEquals(200, $response->status());
        $this->missingFromDatabase('cart_items', [
            'cart_id' => $this->cart->id,
        ]);
    }
    public function addProductCart()
    {
        $response = $this->call('POST', 'cart/', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => rand(1, 10),
        ]);
        return $response;
    }
    public function addMoreProduct()
    {
        $anotherProduct = Product::whereNotIn('id', $this->cart->cartItems()->pluck('product_id'))->inRandomOrder()->first();
        if (empty($anotherProduct)) {
            $anotherProduct = $this->createProduct();
        }
        $response = $this->call('POST', 'cart/', [
            'user_id' => $this->user->id,
            'product_id' => $anotherProduct->id,
            'quantity' => rand(1, 10),
        ]);
        return $response;
    }
    public function testFailAddMoreThen50QuantityCart()
    {
        $this->testClearProductsCart();
        $response = $this->call('POST', 'cart/', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 55,
        ]);
        $this->assertEquals(400, $response->status());
        $this->missingFromDatabase('cart_items', [
            'cart_id' => $this->cart->id,
            'product_id' => $this->product->id,
        ]);
    }
    public function testFailAddMoreThen10ProductsCart()
    {
        $this->testClearProductsCart();
        $response = $this->addProductCart();
        $this->assertEquals(200, $response->status());
        $cart = $this->cart->cartItems()->count();
        while ($cart <= 9) {
            $response = $this->addMoreProduct();
            $this->assertEquals(200, $response->status());
            $cart++;
        }
        $anotherProduct = Product::whereNotIn('id', $this->cart->cartItems()->pluck('product_id'))->inRandomOrder()->first();
        if (empty($anotherProduct)) {
            $anotherProduct = $this->createProduct();
        }
        $response = $this->call('POST', 'cart/', [
            'user_id' => $this->user->id,
            'product_id' => $anotherProduct->id,
            'quantity' => rand(1, 10),
        ]);
        $this->assertEquals(500, $response->status());
        $this->missingFromDatabase('cart_items', [
            'cart_id' => $this->cart->id,
            'product_id' => $anotherProduct->id,
        ]);
    }
    public function testAddJustOneProductCart()
    {
        $this->testClearProductsCart();
        $response = $this->addProductCart();
        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('cart_items', [
            'product_id' => $this->product->id
        ]);
    }

    public function testAddOneMoreProductCart()
    {
        $this->testClearProductsCart();
        $response = $this->addProductCart();
        $this->assertEquals(200, $response->status());
        $response = $this->addMoreProduct();
        $this->assertEquals(200, $response->status());
    }
    public function testUpdateProduct()
    {
        $this->testAddJustOneProductCart();
        $response = $this->call('PATCH', 'cart/' . $this->user->id, [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => '5',
        ]);
        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('cart_items', [
            'product_id' => $this->product->id,
            'quantity' => 5,
        ]);
    }
    public function testRemoveProductCart()
    {
        $this->data();
        $response = $this->call('POST', 'cart/remove-item/', [
            'cart_id' => $this->cart->id,
            'product_id' => $this->cart->cartItems->first()->product_id,
            'user_id' => $this->user->id,
        ]);
        $this->assertEquals(200, $response->status());
        $this->missingFromDatabase('cart_items', [
            'cart_id' => $this->cart->id,
            'product_id' => $this->cart->cartItems->first()->product_id,
        ]);
    }
    public function testResultCart()
    {
        $this->testAddJustOneProductCart();
        $response = $this->call('GET', 'cart/total-cart/' . $this->user->id);
        $this->assertEquals(200, $response->status());
    }
}
