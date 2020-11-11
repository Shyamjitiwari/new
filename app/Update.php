<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    protected $table = 'updates';

    protected $fillable = [
        'phone_number','user_id', 'is_teacherOrAdmin', 'teacher_id', 'content',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDayDateTimeString();
    }

    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id', 'id');
    }

    public function surveys()
    {
        return $this->hasMany('App\Survey', 'update_id', 'id');
    }
}
