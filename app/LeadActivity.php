<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadActivity extends Model
{
    public function created_by(){
        return $this->belongsTo('App\User', 'created_id', 'id');
    }

    public function updated_by(){
        return $this->belongsTo('App\User', 'updated_id', 'id');
    }

    public function activities()
    {
        return $this->morphTo();
    }

    public function leads()
    {
        return $this->belongsTo('App\Lead');
    }
}
