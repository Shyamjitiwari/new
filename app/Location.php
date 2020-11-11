<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'location_name', 'address', 'secret_code', 'show_free_session', 'in_camps', 'online',
        'classroom_url', 'is_deleted', 'created_at', 'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function taskclasses()
    {
        return $this->hasMany(TaskClass::class);
    }

    public function camps()
    {
        return $this->hasMany(Camp::class);
    }

//    public function permanent_class_schedules()
//    {
//        return $this->hasMany(PermanentClassSchedule::class, 'location_id', 'id');
//    }

    public function stripes()
    {
        return $this->hasMany('App\Stripe');
    }

    public function teacherAvailableTimeSlots()
    {
        return $this->belongsTo(TeacherAvailabelTimeSlot::class);
    }
}
