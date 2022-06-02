<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserPostRequest
{
    public function __construct($data)
    {
        $validator = Validator::make($data, [
            'username' => 'required|max:100|min:5',
            'password' => 'required|max:100|min:8',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails())
            abort(400, $validator->errors());

        $this->map((object)$data);
    }

    private function map($object)
    {
        $this->username = property_exists($object, 'username') ? $object->username : null;
        $this->password = property_exists($object, 'password') ? $object->password : null;
        $this->email = property_exists($object, 'email') ? $object->email : null;
    }

    public function parse()
    {
        $result = array(
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email
        );

        return $result;
    }
}
