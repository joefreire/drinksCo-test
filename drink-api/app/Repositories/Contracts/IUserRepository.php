<?php

namespace App\Repositories\Contracts;

interface IUserRepository extends IGenericRepository
{
    public function userRegister(array $data);
    public function userLogin(array $data);
}
