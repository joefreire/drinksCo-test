<?php

namespace App\Repositories\Contracts;

interface IGenericRepository
{
    public function getAll($order, $sort, $filter, $field);
    public function get($page, $limit, $order, $sort, $filter, $field);
    public function find($id, $field);
}
