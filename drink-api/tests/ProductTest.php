<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Product;

class ProductTest extends TestCase
{
    public function testCreateProduct()
    {
        $rand = rand();
        $price = rand(2,30);
        $response = $this->call('POST', 'product/', [
            'title' => 'TestPHPUnit Product '.$rand,
            'price' => $price,
            'price_sale' => ($price * 0.9),
            'min_to_sale' => rand(2,10)
        ]);
        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('products', ['title' => 'TestPHPUnit Product '.$rand]);
    }
    public function testGetAllProduct()
    {
        $response = $this->call('GET', '/product');
        $this->assertEquals(200, $response->status());
    }
    public function testGetOneProduct()
    {
        $product = Product::where('title','like','TestPHPUnit%')->first();
        if(empty($product)){
            $this->testCreateProduct();
            $product = Product::where('title','like','TestPHPUnit%')->first();
        }
        $response = $this->call('GET', '/product/'.$product->id );
        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('products', ['id' => $product->id]);
    }
    public function testUpdateProduct()
    {
        $product = Product::where('title','like','TestPHPUnit%')->inRandomOrder()->first();
        $price = (float) rand(5,50);
        $response = $this->call('PATCH', '/product/'.$product->id , [
            'title' => 'TestPHPUnit Updated Product '.$price,
            'price' => $price,
            'price_sale' => $price / 10,
            'min_to_sale' => rand(3,10),
        ]);
        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('products', ['title' => 'TestPHPUnit Updated Product '.$price]);
    }
    public function testFailCreateProduct()
    {
        $rand = rand();
        $response = $this->call('POST', 'product/', [
            'title' => 'TestPHPUnit DELETED Product '.$rand,
            'price' => '3',
        ]);
        $this->assertEquals(400, $response->status());
        $this->notSeeInDatabase('products', ['title' => 'TestPHPUnit DELETED Product '.$rand]);
    }
    public function testDeleteProduct()
    {
        $this->testCreateProduct();
        $id = Product::where('title','like','TestPHPUnit%')->first()->id;
        $response = $this->call('delete', '/product/'.$id);
        $this->assertEquals(200, $response->status());
        $this->notSeeInDatabase('products', ['id' => $id]);
    }
}
