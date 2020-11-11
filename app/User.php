<?php

namespace App;

use App\Traits\Common;
use App\Traits\Search;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,Search,Common;

    protected $fillable = ['parent_id','name', 'email', 'password','impersonate_id'];

    protected $hidden = ['password', 'remember_token',];

    protected $casts = ['email_verified_at' => 'datetime', 'created_at' => 'datetime:d-m-Y', 'updated_at' => 'datetime:d-m-Y',];

    public function created_lead_statuses()
    {
        return $this->hasMany('App\LeadStatus','created_id','id');
    }

    public function created_lead_sources()
    {
        return $this->hasMany('App\LeadSource','created_id','id');
    }

    public function created_leads()
    {
        return $this->hasMany('App\Lead','created_id','id');
    }

    public function created_lead_histories()
    {
        return $this->hasMany('App\LeadHistory','created_id','id');
    }

    public function created_comments()
    {
        return $this->hasMany('App\Comment','created_id','id');
    }

    public function created_roles()
    {
        return $this->hasMany('App\Role','created_id','id');
    }

    public function created_permissions()
    {
        return $this->hasMany('App\Permission','created_id','id');
    }

    public function created_projects()
    {
        return $this->hasMany('App\Project','created_id','id');
    }

    public function created_user_groups()
    {
        return $this->hasMany('App\UserGroup','created_id','id');
    }

    public function created_apis()
    {
        return $this->hasMany('App\Api','created_id','id');
    }

    public function created_attendances()
    {
        return $this->hasMany('App\Attendance','created_id','id');
    }

    public function updated_lead_statuses()
    {
        return $this->hasMany('App\LeadStatus','updated_id','id');
    }

    public function updated_lead_sources()
    {
        return $this->hasMany('App\LeadSource','updated_id','id');
    }

    public function updated_leads()
    {
        return $this->hasMany('App\Lead','updated_id','id');
    }

    public function updated_lead_histories()
    {
        return $this->hasMany('App\LeadHistory','updated_id','id');
    }

    public function updated_comments()
    {
        return $this->hasMany('App\Comment','updated_id','id');
    }

    public function updated_roles()
    {
        return $this->hasMany('App\Role','updated_id','id');
    }

    public function updated_permissions()
    {
        return $this->hasMany('App\Permission','updated_id','id');
    }

    public function updated_projects()
    {
        return $this->hasMany('App\Project','updated_id','id');
    }

    public function updated_user_groups()
    {
        return $this->hasMany('App\UserGroup','updated_id','id');
    }

    public function updated_apis()
    {
        return $this->hasMany('App\Api','updated_id','id');
    }

    public function updated_attendances()
    {
        return $this->hasMany('App\Attendance','updated_id','id');
    }

    public function assignedLeads()
    {
        return $this->belongsToMany('App\Lead');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function history()
    {
        return $this->morphMany('App\LeadHistory', 'historical');
    }

    public function manager()
    {
        return $this->belongsTo('App\User', 'parent_id', 'id');
    }

    public function team()
    {
        return $this->hasMany('App\User', 'parent_id', 'id');
    }

    public function activities()
    {
        return $this->morphMany('App\Activity', 'activity');
    }

    public function isSuperAdmin()
    {
        return $this->role_id == 1;
    }

    public function isAdmin()
    {
        return $this->role_id == 2;
    }

    public function user_group()
    {
        return $this->belongsTo(UserGroup::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id');
    }

    public function isAttendanceMarked(){

        return  $this->attendances->where('date' ,'>=', Carbon::now()->startOfDay())->where('type','check_in')->count() ? true : false;
      }

    public function isAbsentForToday(){

        return  $this->attendances->where('date' ,'>=', Carbon::now()->startOfDay())->where('type','absent')->count() ? true : false;
      }
      public function scopePresentUsers($query){

        return  $query->whereHas('attendances',function( $q ) {
            $q->where('date' ,'>=', Carbon::now()->startOfDay())->where('type','!=','absent');
            });
      }
      public function isCheckedOut(){

        return  $this->attendances->where('date' ,'>=', Carbon::now()->startOfDay())->where('type','check_out')->count() ? true : false;
      }
}
