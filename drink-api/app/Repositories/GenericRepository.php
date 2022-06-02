<?php

namespace App\Repositories;

use App\Repositories\Contracts\IGenericRepository;

class GenericRepository implements IGenericRepository
{
    protected $model;

    protected $callback = true;

    public function __construct($model, $callback = true)
    {
        $this->model = $model;
        $this->callback = $callback;
    }

    public function getAll($order = null, $sort = null, $filter = null, $field = [])
    {
        $orderBy = $order ? $order : $this->model->getKeyName();
        $sortBy = $sort ? $sort : $this->model->getSortDirection();

        $data = [
            'name' =>  $filter,
            'field' =>  $field,
        ];

        return $this->model
            ->orderBy($orderBy, $sortBy)
            ->filter($data)->get();
    }

    public function get($page, $limit, $order = null, $sort = null, $filter = null, $field = [])
    {
        $orderBy = $order ? $order : $this->model->getKeyName();
        $sortBy = $sort ? $sort : $this->model->getSortDirection();

        $data = [
            'name' =>  $filter,
            'field' => $field
        ];

        return $this->model
            ->filter($data)
            ->orderBy($orderBy, $sortBy)
            ->offset(($page - 1) * $page)
            ->limit($limit)
            ->paginate($limit);
    }

    public function find($id, $field = null)
    {
        $data = [
            'id' =>  $id,
            'field' =>  $field,
        ];

        return $this->model->filter($data)->get();
    }
}
