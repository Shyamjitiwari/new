<?php

namespace App;

class Builder extends App
{
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
