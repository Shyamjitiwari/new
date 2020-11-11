<?php


namespace App\Helper;

use App\Activity;

class LogActivity
{
    public static function add($model, $remark, $note=null, $payload=null)
    {
        $activity = new Activity;
        $activity->system_remark = $remark;
        $activity->notes = $note;
        $activity->payload = $payload;
        $model->activities()->save($activity);
    }
}
