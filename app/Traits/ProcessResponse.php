<?php

namespace App\Traits;

trait ProcessResponse {
    public function processResponse($status, $code = null, $message = '', $data = null){
        if($status == 'success'){
            return response()->json([
                'status' => $status,
                'code' => $code,
                'message' => $message,
                'data' => ($data) ? $data : null,
            ]);
        } else if($status == 'unauthorize'){
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'You are not authorized for this action!',
                'data' => ($data) ? $data : null,
            ]);
        } else if($status == 'error'){
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => $message,
                'data' => ($data) ? $data : null,
            ]);
        }
    }
}
