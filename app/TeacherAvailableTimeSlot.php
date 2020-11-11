<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherAvailableTimeSlot extends Model
{
    protected $fillable = [
        'teacher_id', 'day_id','time_id','location_id', 'limit'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
}
