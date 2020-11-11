<?php

namespace App;

class Location extends App
{
    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id', 'id');
    }

    public function projectUnits()
    {
        return $this->hasMany(ProjectUnit::class);
    }

    public function projects(){

        return $this->hasMany(Project::class);
    }

    public function projects_nearby_to_this_location(){

        return $this->hasMany(Project::class, 'nearby_location_id', 'id');
    }

    public function projectUnits_search_by_this_location(){

        return $this->hasMany(Project::class, 'search_location_id', 'id');
    }
}
