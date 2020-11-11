<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name','full_name', 'email', 'phone_number','dob','password',
        'role_id','location_id','country_id','timezone_id', 'goal', 'referral', 'notes', 'topic_id',
        'is_free_session', 'postal_address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function hasRole($roles){
        if(is_string($roles)){
            return !! $this->role->role === $roles;
        }
        else{
            foreach($roles as $role){
                if($this->role->role == $role){
                    return true;
                }
            }
        }
        return false;
    }
    public function surveys()
    {
        return $this->hasMany('App\Survey');
    }

    public function taskClassesWithStudents()
    {
        return $this->belongsToMany(TaskClass::class)
            ->withCount('students')
            ->withCount('teacher')
            ->with(['students.user_updates_dashboard', 'students.latestSurvey', 'students.topics'])
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first');
    }

    public function user_updates_dashboard()
    {
        return $this->hasOne('App\Update', 'user_id', 'id')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
    }

    public function latestSurvey()
    {
        return $this->hasOne('App\Survey', 'student_id', 'id')->orderBy('id', 'desc');
    }

    public function taskclasses()
    {
        return $this->belongsToMany(TaskClass::class)
            ->withCount('students')
            ->withCount('teacher')
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first');
    }

    public function completed_taskclasses()
    {
        return $this->belongsToMany(TaskClass::class)
            ->with('teacher')
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first')
            ->wherePivot('completed', 1);
    }

    public function incomplete_taskclasses()
    {
        return $this->belongsToMany(TaskClass::class)
            ->with('teacher')
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first')
            ->wherePivot('completed', 0);
    }

    public function absent_taskclasses()
    {
        return $this->belongsToMany(TaskClass::class)
            ->with('teacher')
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first')
            ->wherePivot('absent', 1);
    }

    public function present_taskclasses()
    {
        return $this->belongsToMany(TaskClass::class)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first')
            ->wherePivot('absent', 0);
    }

    public function first_taskckass()
    {
        return $this->belongsToMany(TaskClass::class)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first')
            ->wherePivot('first', 1);
    }


    public function free_taskclasses()
    {
        return $this->belongsToMany(TaskClass::class)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first')
            ->wherePivot('is_free_session', 1);
    }

    public function recurring_taskclasses()
    {
        return $this->belongsToMany(TaskClass::class)
            ->withPivot('id','task_class_id', 'user_id', 'completed', 'absent', 'free', 'recurring', 'first')
            ->wherePivot('recurring', 1);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }
    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }


    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'created_by', 'id');
    }

    public function lesson_categories()
    {
        return $this->hasMany(LessonCategory::class, 'created_by', 'id');
    }

    public function lesson_sub_categories()
    {
        return $this->hasMany(LessonSubCategory::class, 'created_by', 'id');
    }

    public function updates()
    {
        return $this->hasMany('App\Update', 'teacher_id', 'id');
    }

    public function user_updates()
    {
        return $this->hasMany('App\Update', 'user_id', 'id')
            ->with(['teacher', 'surveys'])
            ->orderBy('created_at', 'desc')
            ->limit(5);
    }

    public function permanent_class_schedules()
    {
        return $this->hasMany(PermanentClassSchedule::class, 'student_id', 'id');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role_id', 1);
    }

    public function scopeTeachers($query)
    {
        return $query->where('role_id', 2);
    }

    public function scopeParents($query)
    {
        return $query->where('role_id', 3);
    }

    public function scopeStudents($query)
    {
        return $query->where('role_id', 4);
    }

    public function lecture_categories()
    {
        return $this->belongsToMany(LectureCategory::class);
    }

    public function leads_created()
    {
        return $this->hasMany(Lead::class, 'created_id', 'id');
    }

    public function leads_statuses_created()
    {
        return $this->hasMany(LeadStatus::class, 'created_id', 'id');
    }

    public function leads_sources_created()
    {
        return $this->hasMany(LeadSource::class, 'created_id', 'id');
    }

    public function leads_activities_created()
    {
        return $this->hasMany(LeadActivity::class, 'created_id', 'id');
    }

    public function leads_updated()
    {
        return $this->hasMany(Lead::class, 'updated_id', 'id');
    }

    public function leads_statuses_updated()
    {
        return $this->hasMany(LeadStatus::class, 'updated_id', 'id');
    }

    public function leads_sources_updated()
    {
        return $this->hasMany(LeadSource::class, 'updated_id', 'id');
    }

    public function leads_activities_updated()
    {
        return $this->hasMany(LeadActivity::class, 'updated_id', 'id');
    }

    public function leads()
    {
        return $this->hasMany('App\User');
    }

    public function surveysForStudent()
    {
        return $this->hasMany('App\Survey', 'student_id', 'id');
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function references()
    {
        return $this->belongsToMany(Reference::class);
    }
}