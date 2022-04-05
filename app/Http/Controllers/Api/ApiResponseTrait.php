<?php

namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{
    public function apiResponse($data = null, $message = null, $statusCode = null)
    {
        $array = [
            'data' => $data,
            'message' => $message,
            'statusCode' => $statusCode
        ];
        return response($array, 200);
    }
}
