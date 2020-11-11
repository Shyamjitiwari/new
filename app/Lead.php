<?php

namespace App;

use App\Traits\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use Search;

    protected $fillable = [
        'name', 'phone_number', 'email', 'description', 'form_submitted_at', 'free_session_date', 'student_id',
        'lead_source_id', 'lead_status_id', 'created_id', 'updated_id', 'created_at', 'updated_at'
    ];

    public function getFormSubmittedAtAttribute($date)
    {
        return Carbon::parse($date)->toDayDateTimeString();
    }

    public function getFreeSessionDateAttribute($date)
    {
        return Carbon::parse($date)->toDayDateTimeString();
    }

    public function created_by(){
        return $this->belongsTo('App\User', 'created_id', 'id');
    }

    public function updated_by(){
        return $this->belongsTo('App\User', 'updated_id', 'id');
    }

    public function lead_status()
    {
        return $this->belongsTo('App\LeadStatus');
    }

    public function lead_source()
    {
        return $this->belongsTo('App\LeadSource');
    }

    public function lead_activities()
    {
        return $this->hasMany('App\LeadActivity')->orderBy('created_at', 'desc');
    }

    public function lead_activity_remarks()
    {
        return $this->hasMany('App\LeadActivity')
            ->where('remarks', '<>', null)
            ->orderBy('created_at', 'desc');
    }

    public function activities()
    {
        return $this->morphMany('App\LeadActivity', 'activities');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function student()
    {
        return $this->belongsTo('App\User');
    }
}
