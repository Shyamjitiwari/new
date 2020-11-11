<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';
    protected $fillable = [
        'name', 'image_name', 'free_session', 'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function taskclasses()
    {
        return $this->belongsToMany(TaskClass::class);
    }
}
