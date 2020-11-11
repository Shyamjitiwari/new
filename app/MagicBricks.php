<?php

namespace App;

class MagicBricks extends App
{
    protected $fillable = [
        'mb_id', 'received_at', 'name', 'api_id','email', 'phone', 'project_name', 'project_details', 'query_info',
        'payload', 'status', 'created_at', 'updated_at'
    ];

    public function api(){

        return $this->belongsTo(Api::class);
    }
}
