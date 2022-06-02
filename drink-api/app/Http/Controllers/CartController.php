<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CartPostRequest;
use App\Http\Requests\CartPatchRequest;
use App\Models\Cart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\CartService;
use App\Http\Requests\CartRemoveProductRequest;

class CartController extends Controller
{

    public function index()
    {
        $data = Cart::all();
        if (count($data)) {
            return $this->buildResponses('success', 'Cart', $data);
        } else {
            return $this->buildFailResponse('fail', 'Cart Not Found');
        }
    }

    public function show($id)
    {
        $data = Cart::findOrFail($id);
        if ($data) {
            return $this->buildResponse('success', $data);
        } else {
            return $this->buildFailResponse('fail', 'Cart not found');
        }
    }

    public function store(Request $request)
    {
        $validate = new CartPostRequest($request->all());
        $data = $validate->parse();
        $service = new CartService($data['user_id']);
        $cart = $service->addProductCart($data['product_id'], $data['quantity']);
        return $this->buildResponse('success', $cart);
    }
    public function update(Request $request)
    {
        $validate = new CartPatchRequest($request->all());
        $data = $validate->parse();
        $service = new CartService($data['user_id']);
        $cart = $service->updateProductCart($data['product_id'], $data['quantity']);
        return $this->buildResponse('success', $cart);
    }
    public function removeAllProducts($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->cartItems()->delete();
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

    public function destroy($id)
    {
        try {
            Cart::destroy($id);
            return $this->buildResponse('success');
        } catch (ModelNotFoundException $exception) {
            return $this->buildFailResponse("fail", "No query result for " . $id);
        }
    }
}
