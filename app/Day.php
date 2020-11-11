<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $table = 'days';
    protected $fillable = [
        'name',
    ];

    public function teacherAvailableTimeSlots()
    {
        return $this->belongsTo(TeacherAvailabelTimeSlot::class);
    }

}
