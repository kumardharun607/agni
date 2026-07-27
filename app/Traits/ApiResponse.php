<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($message,$data=[])
    {
        return response()->json([
            'status'=>true,
            'message'=>$message,
            'data'=>$data
        ]);
    }

    public function error($message)
    {
        return response()->json([
            'status'=>false,
            'message'=>$message
        ],500);
    }
}