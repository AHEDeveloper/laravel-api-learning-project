<?php

namespace App\Classes;

class ApiResponseClass
{
    public static function apiResponse($status, $message, $data, $code)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
