<?php

namespace App\Helppers;
use Illuminate\Support\Facades\Response;

class ApiResponse
{

    public static function success($message = 'Success', $data, $code = 200)
    {
        return Response::json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message = 'Error', $code = 500)
    {
        return Response::json([
            'message' => $message
        ], $code);
    }


}




?>