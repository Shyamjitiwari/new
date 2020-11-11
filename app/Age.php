<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    public function taskclasses()
    {
        return $this->belongsToMany(Topic::class);
    }
}
