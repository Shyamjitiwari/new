<?php

namespace App;

class ProjectUnit extends App
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function searchLocation()
    {
        return $this->belongsTo(Location::class, 'search_location_id', 'id');
    }
}
