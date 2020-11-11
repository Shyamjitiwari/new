<?php


namespace App\Helper;

use App\TaskClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    protected $private_firsts_session = 'Private First Session';
    protected $free_session = 'Free Session';

    public static function sendSMS($text, $number)
    {
        $ch = curl_init();
        $api_key = Config::get('settings.sms.api_key');
        $headers = array();
        $headers[] = "X-Toky-Key: {$api_key}";

        $data = array
        (
            "from" => Config::get('settings.sms.from'),
            "email" => Config::get('settings.sms.email'),
            "to" => $number,
            "text" => $text
        );

        $json_data = json_encode($data);

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, Config::get('settings.sms.url'));
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, Config::get('settings.sms.method'));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $json_data);

        $curl_response = curl_exec($ch); // Send request

        // close cURL resource
        curl_close($ch);
    }

    public static function generateUniqueValue($table, $column)
    {
        $random = Str::random(4);

        $isDuplicate = DB::table($table)->where($column, $random)->count();

        while ($isDuplicate > 0)
        {
            $random = Str::random(4);
            $isDuplicate = DB::table($table)->where($column, $random)->count();
        }
        return Str::lower($random);
    }

    public static function generateUniqueFieldValue($table, $column, $value = '', $random = null)
    {
        $random = $value;

        $isDuplicate = DB::table($table)->where($column, $random)->count();

        while ($isDuplicate > 0)
        {
            $random = $value.'_'.rand(1,99);
            $isDuplicate = DB::table($table)->where($column, $random)->count();
        }
        return $random;
    }

    public static function getAge($date)
    {
        return $date ? ' ('.Carbon::parse($date)->age.')' : '';
    }

    public static function isLectureCategoryPresent($user_id, $lecture_category_id)
    {
        return DB::table('users as u')
            ->where('u.id', $user_id)
            ->join('lecture_category_user as lcu', 'lcu.user_id', '=', 'u.id')
            ->join('lecture_categories as lc', 'lcu.lecture_category_id', '=', 'lc.id')
            ->where('lc.is_deleted', '=', 0)
            ->where('lc.id', '=', $lecture_category_id)
            ->count();
    }

    public static function truncateName($name)
    {
        $n = explode(' ', $name);

        return ($n[0] ? $n[0] : null) .' '. (array_key_exists(1, $n) ? $n[1][0] : null);
    }

    public static function getTopic($student)
    {
        return $student->topics()->first() ? ' -'.$student->topics()->first()['name'] : '';
    }

    public static function isFreeOrFirst($student)
    {
        $result = '';
        if($student->pivot->recurring){
            $result .= "<i class='fa fa-circle text-warning'></i>";
        }

        if($student->pivot->free) {
            $result .= "<i class='fa fa-circle text-success'></i> ";
        } else if($student->pivot->first){
            $result .= "<i class='fa fa-circle text-info'></i>";
        }

        if($student->pivot->private){
            $result .= "<i class='fa fa-circle text-primary'></i>";
        }

        return $result;
    }

    public static function revokeToken()
    {
        $user = \App\User::where('email', 'api_user@codewithus.com')->first();
        $tokens = $user->tokens->where('created_at', Carbon::now()->subDay(1))->get();

        foreach($tokens as $token)
        {
            $token->revoke();
        }
    }

    //get the count of students based on start_date of task class
    public static function studentsCountInTaskClass($class_name, $date, $location_id)
    {
        $taskClass = TaskClass::where('name', $class_name)
            ->where('starts_at', '=', $date)
            ->where('is_free_session', 1)
            ->where('location_id', $location_id)
            ->where('is_deleted', 0)
            ->first();

            return $taskClass ? $taskClass->students()->count() : 0;
    }



    public static function isAgeDifferenceMuch($date, $location_id, $dob)
    {
        $taskClass = TaskClass::where('starts_at', $date)
            ->where('is_free_session', 1)
            ->where('location_id',  $location_id)
            ->where('is_deleted', 0)
            ->first();

        if(!$taskClass) {
            return false;
        } else {
            $dobOfExistingStudent =  Carbon::parse($taskClass->students()->first()->dob);
            $dobOfNewStudent =  Carbon::parse($dob);
            if($dobOfExistingStudent->diffInYears($dobOfNewStudent) > 3){
                return true;
            } else {
                return false;
            }
        }
    }

}