<?php
namespace App\Traits;

trait ApiHelpers
{
    protected function onSuccess( $data = [] , $status = 200 ,$message = null )
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function onError($message, $status = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
