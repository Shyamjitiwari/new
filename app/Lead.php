<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Lead extends App
{
    protected $fillable = [
        'parent_id', 'name','mobile','email','remarks','follow_up_at', 'project', 'project_type', 'budget',
        'lead_source_id', 'lead_status_id', 'batch', 'created_id', 'updated_id', 'created_at', 'updated_at'
    ];

    protected $casts = ['follow_up_at' => 'datetime:d-m-Y H:i:s',];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');
    }

    public function lead_status()
    {
        return $this->belongsTo('App\LeadStatus');
    }

    public function lead_source()
    {
        return $this->belongsTo('App\LeadSource');
    }

    public function lead_history()
    {
        return $this->hasMany('App\LeadHistory')->orderBy('created_at', 'desc');
    }

    public function lead_history_remarks()
    {
        return $this->hasMany('App\LeadHistory')
            ->where('remarks', '<>', null)
            ->orderBy('created_at', 'desc');
    }

    public function lead_history_followup_count()
    {
        return $this->hasMany('App\LeadHistory')
            ->where('count', '<>', 0)
            ->orderBy('count', 'desc');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->where('parent_id', null)->orderBy('created_at', 'desc');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function history()
    {
        return $this->morphMany('App\LeadHistory', 'historical');
    }

    public function parent(){
        return $this->belongsTo('App\Lead', 'parent_id', 'id')->withCount('children');
    }

    public function children(){
        return $this->hasMany('App\Lead', 'parent_id', 'id')->orderBy('created_at', 'desc');
    }

    public function scopeFetchAssignedLeads($query, $id)
    {
        return $query->whereHas('assignedUsers',
            function($query) use($id) {
                $query->where('user_id',$id);
            });
    }

    

}
