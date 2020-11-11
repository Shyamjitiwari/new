<?php

namespace App\Traits;

use Carbon\Carbon;

trait Common
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
    }

    public function created_by(){
        return $this->belongsTo('App\User', 'created_id', 'id');
    }

    public function updated_by(){
        return $this->belongsTo('App\User', 'updated_id', 'id');
    }

}
