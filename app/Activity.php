<?php

namespace App;

use App\Constants\ActivityLabels;
use Carbon\Carbon;

class Activity extends App
{
    protected $fillable = ['activity_id','activity_type','system_remark','notes','payload','created_at','updated_at'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse( $date)->toDayDateTimeString();
    }

    public function getSystemRemarkAttribute($data)
    {
        switch ($data) {
            case 'ActivityLabels::_LOGIN' :
                return ActivityLabels::_LOGIN;
                break;
            case 'ActivityLabels::_LOGOUT' :
                return ActivityLabels::_LOGOUT;
                break;
            default :
                return '-';
        }
    }

    public function activity()
    {
        return $this->morphTo();
    }
}
