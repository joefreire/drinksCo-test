<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function buildResponse($status, $data = null)
    {
        return response()->json(
            [
                'status' => $status,
                'data' => $data
            ]
        );
    }

    protected function buildLoginResponse($data)
    {
        return response()->json(
            [
                'data' => $data
            ]
        );
    }

    protected function buildResponses($status, $name, $data)
    {

        $data = [
            'status' => $status,
            $name => $data
        ];

        return response()->json($data);
    }

    protected function buildRelationResponses($status, $name, $data, $relationName, $relation)
    {
        $response = [
            'status' => $status,
            $relationName => $relation,
            $name => $data
        ];

        return response()->json($response);
    }

    protected function buildFailResponse($status, $message = null)
    {
        return response()->json(
            [
                'status' => $status,
                'data' => $message
            ],
        );
    }

    protected function buildErrorResponse($status, $message = null)
    {
        return response()->json(
            [
                'status' => $status,
                'message' => $message
            ],
        );
    }
}
