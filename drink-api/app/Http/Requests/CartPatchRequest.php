<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CartPatchRequest
{
    public function __construct($data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:cart_items,product_id',
            'quantity' => 'required|min:0|max:50',
        ]);

        if ($validator->fails())
            abort(400, $validator->errors());

        $this->map((object)$data);
    }

    private function map($object)
    {
        $this->user_id = property_exists($object, 'user_id') ? $object->user_id : null;
        $this->product_id = property_exists($object, 'product_id') ? $object->product_id : null;
        $this->quantity = property_exists($object, 'quantity') ? $object->quantity : null;
    }

    public function parse()
    {
        $result = array(
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        );

        return $result;
    }
}
