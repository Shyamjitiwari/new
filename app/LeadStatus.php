<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    public function created_by(){
        return $this->belongsTo('App\User', 'created_id', 'id');
    }

    public function updated_by(){
        return $this->belongsTo('App\User', 'updated_id', 'id');
    }

    public function leads(){
        return $this->hasMany('App\Lead');
    }

    public function activities()
    {
        return $this->morphMany('App\LeadActivity', 'activities');
    }
}
