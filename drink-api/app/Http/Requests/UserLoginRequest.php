<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserLoginRequest
{
    public function __construct($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|max:100|min:8',
        ]);

        if ($validator->fails())
            abort(400, $validator->errors());

        $this->map((object)$data);
    }

    private function map($object)
    {
        $this->email = property_exists($object, 'email') ? $object->email : null;
        $this->password = property_exists($object, 'password') ? $object->password : null;
    }

    public function parse()
    {
        $result = array(
            'email' => $this->email,
            'password' => $this->password
        );

        return $result;
    }
}
