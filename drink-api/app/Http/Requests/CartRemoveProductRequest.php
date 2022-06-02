<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;

class CartRemoveProductRequest
{
    public function __construct($data)
    {
        $validator = Validator::make($data, [
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:cart_items,product_id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails())
            abort(400, $validator->errors());

        $this->map((object)$data);
    }

    private function map($object)
    {
        $this->cart_id = property_exists($object, 'cart_id') ? $object->cart_id : null;
        $this->product_id = property_exists($object, 'product_id') ? $object->product_id : null;
        $this->user_id = property_exists($object, 'user_id') ? $object->user_id : null;
    }
    
    public function parse()
    {
        $result = array(
            'cart_id' => $this->cart_id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
        );

        return $result;
    }
}
