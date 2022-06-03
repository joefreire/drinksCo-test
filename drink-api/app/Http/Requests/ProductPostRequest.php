<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductPostRequest
{
    public function __construct($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|max:100|min:5',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'required|numeric|min:0|lte:price',
            'min_to_sale' => 'nullable|numeric|min:1',
        ]);

        if ($validator->fails())
            abort(400, $validator->errors());

        $this->map((object)$data);
    }

    private function map($object)
    {
        $this->title = property_exists($object, 'title') ? $object->title : null;
        $this->price = property_exists($object, 'price') ? $object->price : null;
        $this->price_sale = property_exists($object, 'price_sale') ? $object->price_sale : 0;
        $this->min_to_sale = property_exists($object, 'min_to_sale') ? $object->min_to_sale : 0;
    }

    public function parse()
    {
        $result = array(
            'title' => $this->title,
            'price' => $this->price,
            'price_sale' => $this->price_sale,
            'min_to_sale' => $this->min_to_sale,
        );

        return $result;
    }
}
