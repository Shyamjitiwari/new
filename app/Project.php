<?php

namespace App;

class Project extends App
{
    public function leadhistories()
    {
        return $this->belongsToMany('App\LeadHistory');
    }

    public function builder()
    {
        return $this->belongsTo(Builder::class);
    }

    public function units()
    {
        return $this->hasMany(ProjectUnit::class);
    }

    public function location(){

        return $this->belongsTo(Location::class);
    }

    public function nearby_location(){

        return $this->belongsTo(Location::class, 'nearby_location_id', 'id');
    }
}
