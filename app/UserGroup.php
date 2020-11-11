<?php

namespace App;

class UserGroup extends App
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function apis()
    {
        return $this->hasMany(Api::class);
    }
}
