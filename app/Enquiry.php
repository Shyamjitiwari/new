<?php

namespace App;

class Enquiry extends App
{
    public function parent(){
        return $this->belongsTo('App\Enquiry', 'parent_id', 'id')->withCount('children');
    }
    public function children()
    {
        return $this->hasMany('App\Enquiry', 'parent_id', 'id')->orderBy('created_at', 'desc');
    }
}
