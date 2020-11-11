<?php

namespace App;

use Carbon\Carbon;

class LeadHistory extends App
{
    protected $fillable = ['lead_id', 'historical_id', 'historical_type', 'remarks', 'follow_up_at','created_id', 'updated_id'];

    protected $casts = ['follow_up_at' => 'datetime:d-m-Y H:i:s',];

    public function historical()
    {
        return $this->morphTo();
    }

    public function leads()
    {
        return $this->belongsTo('App\Lead');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    public function isFollowupHandled(){
        
        $leads = LeadHistory::where('created_at','>',Carbon::parse($this->created_at))->get();
        
        foreach($leads as $lead){
            if(($this->lead_id == $lead->lead_id)){

                return true;
            }
        }
        return false;
    }
}
