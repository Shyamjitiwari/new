<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\TaskClass;
use App\Teacher;
use App\User;
use App\Role;
use App\Location;
use App\Topic;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin');
    }

    public function getLocations()
    {
        $user = Auth::user();
        $role = $user->role->role;
        //$role = "admin";
        if($role == "admin"){
            $locationData = Location::where('is_deleted', false)->get();
        }
        elseif($role == "teacher"){
            $locationData = $user->locations()->get();
            // $locationData = Location::where(['is_deleted' => false,
            //                                  'id' => $locationId, ])->get();
        }
        $locations = array();
        foreach($locationData as $location){
            $dataArray = ["location_id" => $location['id'],
                "location_name" => $location['location_name'],
            ];
            array_push($locations,$dataArray);
        }
        return response()->json(['locations'=> $locations],200);
    }

    public function getCalendarEvents(Request $request){

        if($request->input('teacher_id')) {
            $taskClasses = TaskClass::where(
                [
                    'is_deleted' => false,
                    'is_completed' => false,
                    'location_id' => $request->location_id
                ])
                ->whereDate('starts_at', '>', Carbon::now()->subWeeks(1)->startOfDay())
                ->whereHas('teacher', function($query) use($request) {
                    $query->where('user_id', $request->input('teacher_id'));
                })
                ->orderBy('starts_at','ASC')
                ->get();
        } else {
            $taskClasses = TaskClass::where(
                [
                    'is_deleted' => false,
                    'is_completed' => false,
                    'location_id' => $request->location_id
                ])
                ->whereDate('starts_at', '>', Carbon::now()->subWeeks(1)->startOfDay())
                ->orderBy('starts_at','ASC')->get();
        }

        $events = array();
        foreach($taskClasses as $taskClass){
            $students = array();
            $teacher = "Un-Assigned";
            $starts_at = $taskClass->starts_at;
            $ends_at = $taskClass->ends_at;
            $isFreeSession = $taskClass->is_free_session;
            $isRecurring = $taskClass->recurring;
            $isFirst = $taskClass->first;
            $timestamp_starttime = strtotime($taskClass->starts_at);
            $startTime = date('h:i A', $timestamp_starttime);

            $timestamp_endtime = strtotime($taskClass->ends_at);
            $endTime = date('h:i A', $timestamp_endtime);

            $teacher = "<a style='color:white' href='/task-classes-profile/$taskClass->id'>".
                $startTime."-".$endTime."<br>".$teacher."<br>".$taskClass->name."</a>";
            $pivotTableData = $taskClass->users;
            foreach($pivotTableData as $data){
                $role = Role::where('id',$data->role_id)->value('role');
                if($role == "teacher"){
                    if($taskClass->camp_id) {
                        $teacher = "<a style='color:white' href='/task-classes-profile/$taskClass->id'>"
                            . $startTime . "-" . $endTime . "<br><span style='font-size: large;'>" . $data->full_name . "</span><br>"
                            . "<span style='background-color: ".$taskClass->camp->bg_color."; color: white; padding:2px'>" . $taskClass->name . "</span>" . "</a>";
                    } else {
                        $teacher = "<a style='color:white' href='/task-classes-profile/$taskClass->id'>"
                            . $startTime . "-" . $endTime . "<br><span style='font-size: large;'>" . $data->full_name . "</span><br>"
                            . $taskClass->name . "</a>";
                    }
                }
                else{
                    $dataArray = [
                        "student_id" => $data->id,
                        "student_name" => Helper::isFreeOrFirst($data) . $data->full_name . Helper::getAge($data->dob). Helper::getTopic($data),
                        'completed' => $data->pivot->completed ? 1 : 0,
                        'absent' => $data->pivot->absent ? 1 : 0,
                        "starts_at" => $starts_at,
                        "ends_at" => $ends_at,
                    ];
                    array_push($students,$dataArray);
                }
            }
            if(count($pivotTableData) > 0){
                $title = "<b>".$teacher."</b>";
                $content = '<div style="background-color:#FCF3CF;margin:5px;color:black">';
                foreach($students as $student){
                    if($student['completed'] == 1) {
                        $content = $content . "<a title='Completed' style='background-color:darkgrey; color:black' href='/edit_student_profile/" . $student['student_id'] . "'>" . $student['student_name'] . '</a></div><div style="background-color:#FCF3CF;margin:5px;color:black">';
                    } else if($student['absent'] == 1) {
                        $content = $content . "<a title='Absent' style='background-color:red; color:white' href='/edit_student_profile/" . $student['student_id'] . "'>" . $student['student_name'] . '</a></div><div style="background-color:#FCF3CF;margin:5px;color:black">';
                    }
                    else {
                        $content = $content . "<a class='text-capitalize' href='/edit_student_profile/" . $student['student_id'] . "'>" . $student['student_name'] . '</a></div><div style="background-color:#FCF3CF;margin:5px;color:black">';
                    }
                    $starts_at = $student['starts_at'];
                    $ends_at = $student['ends_at'];
                }
                if($isFreeSession) {
                    $bg = 'sport';
                } elseif ($isRecurring) {
                    $bg = 'bg-info';
                } else {
                    $bg = 'leisure';
                }
                $content = $content."</div>";
                $dataArray = [
                    "start" => $starts_at,
                    "end" => $ends_at,
                    "title" => $title,
                    "content" => $content,
                    "class" => $bg
                ];
                array_push($events, $dataArray);
            }
        }

        if(count($events) <= 0){
            return response()->json(['response_msg'=>'No scheduled classes are found for this Location.'],200);
        }
        else{
            return response()->json(['events'=> $events],200);
        }
    }

}
