<?php

namespace App;

class Housing extends App
{
    protected $fillable = [
        'type', 'lead_date', 'api_id','apartment_names', 'country_code', 'service_type', 'category_type',
        'locality_name','city_name','lead_name','lead_email','lead_phone', 'project_id',
        'project_name', 'payload', 'status'
    ];

    public function api(){

        return $this->belongsTo(Api::class);
    }
}
