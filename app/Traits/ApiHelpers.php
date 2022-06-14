<?php

namespace App\Traits;

trait ApiHelpers
{
    protected function onSuccess($data = [], $status = 200, $message = null)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function onError($message, $status = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $status);
    }
}
