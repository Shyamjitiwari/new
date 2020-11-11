<?php

namespace App;

class Acre extends App
{
    protected $fillable = [
        'received_at', 'name', 'api_id','email', 'phone', 'project_name', 'project_details', 'project_id', 'query_info',
        'phone_verification_status', 'email_verification_status', 'identity', 'property_code', 'sub_user_name',
        'payload', 'created_at', 'updated_at'
    ];

    public function api(){

        return $this->belongsTo(Api::class);
    }
}
