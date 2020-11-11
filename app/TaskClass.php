<?php

namespace App;

use App\Traits\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TaskClass extends Model
{
    use Search;

    protected $table = 'task_classes';
    
    protected $fillable = [
        'name', 'location_id', 'is_completed', 'is_free_session', 'recurring', 'task_class_type_id', 'is_deleted',
        'starts_at', 'ends_at', 'created_at', 'updated_at', 'student_limit'
    ];

    public function getStartsAtAttribute($value)
    {
        return Carbon::parse($value)->toDayDateTimeString();
    }

    public function getEndsAtAttribute($value)
    {
        return Carbon::parse($value)->toDayDateTimeString();
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function teacher()
    {
        return $this->belongsToMany(User::class)
            ->where('users.role_id', 2)
            ->orderBy('id', 'desc')
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');

    }

    public function students()
    {
        return $this->belongsToMany(User::class)
            ->where('users.role_id', 4)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function completed_user_classes()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('completed', 1)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function completed_absent_taskclasses(){
        return $this->belongsToMany(User::class)
            ->wherePivot('completed', 1)
            ->orWherePivot('absent', 1)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function incomplete_user_classes()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('completed', 0)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function absent_users()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('absent', 1)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function present_users()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('absent', 0)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function free_session_user_classes()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('is_free_session', 1)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function recurring_user_classes()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('recurring', 1)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first', 'private');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function ages()
    {
        return $this->belongsToMany(Age::class);
    }

    public function task_class_type()
    {
        return $this->belongsTo(TaskClassType::class);
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

}
