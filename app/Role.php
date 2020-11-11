<?php

namespace App;

class Role extends App
{
    protected $fillable = ['name', 'status', 'created_at', 'updated_at'];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
