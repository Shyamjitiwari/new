<?php

namespace App;

class LeadSource extends App
{
    public function leads(){
        return $this->hasMany('App\Lead');
    }

    public function history()
    {
        return $this->morphMany('App\LeadHistory', 'historical');
    }
}
