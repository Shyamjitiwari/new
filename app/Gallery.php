<?php

namespace App;

class Gallery extends App
{
    protected $fillable = [
        'category_id', 'status', 'updated_id', 'created_id', 'created_at', 'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id')->where('status','active');
    }


}
