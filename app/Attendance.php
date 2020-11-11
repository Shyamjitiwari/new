<?php

namespace App;

class Attendance extends App
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
