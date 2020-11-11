<?php

namespace App;

class Permission extends App
{
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
