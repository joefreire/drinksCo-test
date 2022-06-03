<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CartPostRequest;
use App\Http\Requests\CartPatchRequest;
use App\Services\CartService;
use App\Http\Requests\CartRemoveProductRequest;

//TODO: Authentication
class CartController extends Controller
{
    public function store(Request $request)
    {
        $validate = new CartPostRequest($request->all());
        $data = $validate->parse();
        $service = new CartService($data['user_id']);
        $cart = $service->addProductCart($data['product_id'], $data['quantity']);
        return $this->buildResponse('success', $cart);
    }
    public function update(Request $request, $user_id)
    {
        $validate = new CartPatchRequest($request->all());
        $data = $validate->parse();
        $service = new CartService($data['user_id']);
        $cart = $service->updateProductCart($data['product_id'], $data['quantity']);
        return $this->buildResponse('success', $cart);
    }
    public function removeAllProducts($user_id)
    {
        $service = new CartService($user_id);
        $cart = $service->removeAllProductsCart();
        return $this->buildResponse('success', $cart);
    }
    public function removeProduct(Request $request)
    {
        $validate = new CartRemoveProductRequest($request->all());
        $data = $validate->parse();
        $service = new CartService($data['user_id']);
        $cart = $service->removeProductCart($data['product_id'], $data['cart_id']);
        return $this->buildResponse('success', $cart);
    }

    public function totalCart($user_id)
    {
        $service = new CartService($user_id);
        return $this->buildResponse('success', $service->getResultTotal());
    }
}
