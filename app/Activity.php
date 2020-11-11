<?php

namespace App;

use Carbon\Carbon;
use App\Constants\ActivityLabels;

class Activity extends App
{
    protected $fillable = ['activity_id','activity_type','system_remark','notes','payload','created_at','updated_at'];

    public function getSystemRemarkAttribute($data)
    {
        switch ($data) {
            case 'ActivityLabels::_LOGIN' :
                return ActivityLabels::_LOGIN;
                break;
            case 'ActivityLabels::_LOGOUT' :
                return ActivityLabels::_LOGOUT;
                break;
            case 'ActivityLabels::_LOGOUT_SYSTEM' :
                return ActivityLabels::_LOGOUT_SYSTEM;
                break;
            case 'ActivityLabels::_LEAD_CREATED' :
                return ActivityLabels::_LEAD_CREATED;
                break;
            case 'ActivityLabels::_LEAD_UPDATED' :
                return ActivityLabels::_LEAD_UPDATED;
                break;
            case 'ActivityLabels::_LEAD_DELETED' :
                return ActivityLabels::_LEAD_DELETED;
                break;
            case 'ActivityLabels::_LEAD_SEARCHED' :
                return ActivityLabels::_LEAD_SEARCHED;
                break;
            case 'ActivityLabels::_LEAD_INDEX_VIEWED' :
                return ActivityLabels::_LEAD_INDEX_VIEWED;
                break;
            case 'ActivityLabels::_LEAD_SHOW_VIEWED' :
                return ActivityLabels::_LEAD_SHOW_VIEWED;
                break;
            case 'ActivityLabels::_LEAD_TRANSFERRED' :
                return ActivityLabels::_LEAD_TRANSFERRED;
                break;
            case 'ActivityLabels::_LEAD_ASSIGNED' :
                return ActivityLabels::_LEAD_ASSIGNED;
                break;
            case 'ActivityLabels::_LEAD_SNOOZED' :
                return ActivityLabels::_LEAD_SNOOZED;
                break;
            case 'ActivityLabels::_LEAD_STATUS_UPDATED' :
                return ActivityLabels::_LEAD_STATUS_UPDATED;
                break;
            case 'ActivityLabels::_LEAD_SOURCE_UPDATED' :
                return ActivityLabels::_LEAD_SOURCE_UPDATED;
                break;
            case 'ActivityLabels::_LEAD_PROJECT_UPDATED' :
                return ActivityLabels::_LEAD_PROJECT_UPDATED;
                break;
            case 'ActivityLabels::_LEAD_COMMENT_ADDED' :
                return ActivityLabels::_LEAD_COMMENT_ADDED;
                break;
            case 'ActivityLabels::_LEAD_COMMENT_REPLY_ADDED' :
                return ActivityLabels::_LEAD_COMMENT_REPLY_ADDED;
                break;
            default :
                return 'test';
        }
    }

    public function activity()
    {
        return $this->morphTo();
    }
}
