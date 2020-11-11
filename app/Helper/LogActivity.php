<?php


namespace App\Helper;

use App\Activity;
use App\Impression;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public static function add($remark = null, $note=null)
    {
        $activity = new Activity;
        $activity->system_remark = $remark;
        $activity->notes = $note;
        $activity->payload = json_encode($_SERVER);
        $activity->type = $_SERVER['REQUEST_METHOD'];
        $activity->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
        $activity->url = $_SERVER['REQUEST_URI'];
        $activity->ip = $_SERVER['REMOTE_ADDR'];

        Auth::user() ? Auth::user()->activities()->save($activity) : $activity->save();
    }
}
