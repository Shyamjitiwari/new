<?php

namespace App;

class Api extends App
{
    public function user_group()
    {
        return $this->belongsTo(UserGroup::class);
    }

    public function magic_bricks(){

        return $this->hasMany(MagicBricks::class);
    }

    public function housing(){

        return $this->hasMany(Housing::class);
    }

    public function acres(){

        return $this->hasMany(Acre::class);
    }
}
