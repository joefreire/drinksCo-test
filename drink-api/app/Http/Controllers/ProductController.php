<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductPostRequest;
use App\Http\Requests\ProductPatchRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{

    public function showAll()
    {
        $data = Product::all();
        return $this->buildResponses('success', 'Product', $data);

    }

    public function showOne($id)
    {
        $data = Product::findOrFail($id);
        if ($data) {
            return $this->buildResponse('success', $data);
        } else {
            return $this->buildFailResponse('fail', 'Product not found');
        }
    }

    public function store(Request $request)
    {
        $validate = new ProductPostRequest($request->all());
        $data = $validate->parse();
        $cart = Product::create($data);
        return $this->buildResponse('success', $cart);
    }
    /* TODO */
    public function update(Request $request, $id)
    {
        $validate = new ProductPatchRequest($request->all());
        $data = $validate->parse();
        $product = Product::findOrFail($id)->update($data);
        return $this->buildResponse('success', $product);
    }

    public function destroy($id)
    {
        try {
            Product::destroy($id);
            return $this->buildResponse('success');
        } catch (ModelNotFoundException $exception) {
            return $this->buildFailResponse("fail", "No query result for " . $id);
        }
    }
}
