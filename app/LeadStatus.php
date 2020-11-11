<?php

namespace App;

class LeadStatus extends App
{
    public function leads(){
        return $this->hasMany('App\Lead');
    }

    public function parent(){
        return $this->belongsTo('App\LeadStatus', 'parent_id', 'id');
    }

    public function children(){
        return $this->hasMany('App\LeadStatus', 'parent_id', 'id');
    }

    public function history()
    {
        return $this->morphMany('App\LeadHistory', 'historical');
    }
}
