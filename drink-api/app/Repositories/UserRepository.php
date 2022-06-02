<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Hash;


class UserRepository extends GenericRepository implements IUserRepository
{
    public function __construct()
    {
        parent::__construct(app(User::class));
    }

    public function userRegister(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $register = $this->model->create($data);

        return $register;
    }

    public function userLogin(array $data)
    {
        $user = $this->model->where('email', $data['username'])->first();

        if ($user) {
            if (Hash::check($data['password'], $user['password'])) {
                $result =  $user;
            } else {
                $result = array(
                    'message' => "error to login"
                );
            }
        } else {
            $result = array(
                'message' => "email not found"
            );
        }
        return $result;
    }
}
