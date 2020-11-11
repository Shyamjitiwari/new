<?php

namespace App\Traits;

trait ProcessResponse {
    public function processResponse($data_key, $data, $message, $status, $code){
        if($status == 'success'){
            return response()->json([
                'status' => $status,
                'code' => $code,
                'message' => $message,
                $data_key => ($data) ? $data : null,
            ]);
        } else if($status == 'unauthorize'){
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'You are not authorized for this action!',
                $data_key => ($data) ? $data : null,
            ]);
        } else if($status == 'error'){
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => $message,
                $data_key => ($data) ? $data : null,
            ]);
        }
    }
}
