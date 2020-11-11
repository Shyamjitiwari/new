<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Location;
use App\Mail\BulkMessageCustomSender;
use App\Mail\BulkMessageStudent;
use App\Mail\BulkMessageTeacher;
use App\TaskClass;
use App\Topic;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Country;

class BulkMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function showMessageFormTeachers()
    {
        return view('admin.bulk_messages.teachers');
    }

    public function getBulkMessageData()
    {
        $data['locations'] = Location::where('is_deleted', 0)->get();
//        $data['topics'] = Topic::where('is_deleted', 0)->get();

        return response()->json(['data'=> $data, 'message' => null, 'status'=>'success'],200);
    }

    public function showMessageFormStudents()
    {
        return view('admin.bulk_messages.students');
    }

    public function sendMessage(Request $request)
    {
        $location_id = $request->input('location');
        $date = $request->input('date'); //send message to all students have class on this date
        $m = html_entity_decode($request->input('message'));
        $sender_email = $request->input('sender_email');
        $sender_password = $request->input('sender_password');

        if($request->input('students'))
        {
            $sendTo = 'students';
            //students
            if($request->has('age'))
            {
                $x = 0;
                $users = array();
                $ages = explode(',', $request->input('age'));
                // get all students

                $usersWithDob = DB::table('users as u')
                    ->where('u.role_id', 4)
                    ->join('location_user as lu', 'lu.user_id', '=', 'u.id')
                    ->join('locations as l', 'l.id', '=', 'lu.location_id')
                    ->where('l.id', $location_id)
                    ->where('u.dob', '<>', null)
                    ->select('u.*')
                    ->get();

                // create a new array for all users who fall into the filtered age groups
                foreach($ages as $a)
                {
                  foreach($usersWithDob as $user)
                  {
                      if(Helper::getAge($user->dob) == $a) {
                          $users[$x++] = $user;
                      }
                  }
                }

                //converting the array into collection
                $users = collect($users);
            }
            else if($request->has('date')){
                $users = DB::table('users as u')
                    ->where('u.role_id', 4)
                    ->join('task_class_user as tcu', 'tcu.user_id','=','u.id')
                    ->join('task_classes as tc', 'tc.id','=','tcu.task_class_id')
                    ->whereDate('tc.starts_at', $date)
                    ->select('u.*')
                    ->distinct('u.id')
                    ->get();

            }
            else {
                $users = DB::table('users as u')
                    ->where('u.role_id', 4)
                    ->join('location_user as lu', 'lu.user_id', '=', 'u.id')
                    ->join('locations as l', 'l.id', '=', 'lu.location_id')
                    ->where('l.id', $location_id)
                    ->select('u.*')
                    ->get();
            }
        } else if(!$request->input('students') && !$request->input('task_class_id')) {
            $sendTo = 'teachers';
            $users = DB::table('users as u')
                ->where('u.role_id', 2)
                ->join('location_user as lu', 'lu.user_id', '=', 'u.id')
                ->join('locations as l', 'l.id', '=', 'lu.location_id')
                ->where('l.id', $location_id)
                ->select('u.*')
                ->get();
        } else if(!$request->input('students') && $request->input('task_class_id')){
            $sendTo = 'students';
            $users = DB::table('users as u')
                ->where('u.role_id', 4)
                ->join('task_class_user as tcu', 'tcu.user_id','=','u.id')
                ->join('task_classes as tc', 'tc.id','=','tcu.task_class_id')
                ->where('tc.id', $request->input('task_class_id'))
                ->get();
        }


        if($request->input('type') == 'email')
        {
            $medium = 'Email';
            //set email sender details
            ($sender_email && $sender_password) ? $this->setEmailSenderDetails($sender_email, $sender_password) : null;
            //send email
            foreach($users as $user)
            {
                if(!$sender_password && !$sender_email || !$sender_password && $sender_email || $sender_password && !$sender_email) {
                    if ($request->input('students') || $request->input('task_class_id')) {
                        $user->email ? Mail::to($user->email)->send(new BulkMessageStudent($user->user_name, $m, $request->input('subject'))) : null;
                    } else {
                        $user->email ? Mail::to($user->email)->send(new BulkMessageTeacher($user->user_name, $m, $request->input('subject'))) : null;
                    }
                } else {
                    $user->email ? Mail::to($user->email)->send(new BulkMessageCustomSender($user->user_name, $m, $request->input('subject'))) : null;
                }
            }

        } else {
            $medium = 'SMS';
            //send sms
            foreach($users as $user)
            {
                if($user->phone_number != null && $user->phone_number != ""){
                    $calling_code = Country::where('id', $user->country_id)->value('calling_code');
                    $phoneNumber = $calling_code.$user->phone_number;
                    $msg = 'Hi '.$user->user_name.', '.$m;
                    $user->phone_number ? Helper::sendSMS($msg, $phoneNumber) : null;
                }  
            }
        }

        $count = $users ? $users->count() : 0;

        if($count)
        {
            return response()->json(['data'=> null, 'message' => $medium.' send to '.$count.' '.$sendTo, 'status'=>'success'],200);
        } else {
            return response()->json(['data'=> null, 'message' => "No $sendTo", 'status'=>'error'],404);
        }

    }

    public function setEmailSenderDetails($sender_email, $sender_password)
    {
        config(['mail.username' => $sender_email]);
        config(['mail.password' => $sender_password]);
        config(['mail.driver' => 'smtp']);
        config(['mail.host' => 'smtp.gmail.com']);
        config(['mail.port' => 587]);
        config(['mail.address' => $sender_email]);
        config(['mail.name' => $sender_email]);
        config(['mail.encryption' => 'tls']);
    }
}
