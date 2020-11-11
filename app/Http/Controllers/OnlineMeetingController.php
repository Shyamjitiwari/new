<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Configuration;
use App\Domain\GoogleCalendarApi;
use Redirect;
use App\Domain\GoogleMeetLink;
use App\Role;

class OnlineMeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin|parent|student');
    }

    public function onlineMeetingRoom(){
        $user = Auth::user();
        $role = $user->role->role;
        switch ($role) {
            case 'admin':
                return view('online_meeting.admin_username_online_meeting');
                break;
            case 'teacher':
                return view('online_meeting.teacher_username_online_meeting');
                break; 
            case 'parent':
                return view('online_meeting.parent_username_online_meeting');
                break; 
            case 'student':
                return view('online_meeting.student_username_online_meeting');
                break; 
        }
    }
    
    public function getUsernameForOnlineMeeting(Request $request){
        $user = Auth::user();
        $role = $user->role->role;
        $userNames = array();

        $studentRoleId = Role::where('role','student')->value('id');
        if($role == "parent"){
            $phoneNumber = $user->phone_number;
            $users = User::where(['phone_number' => $phoneNumber,
                                  'role_id' => $studentRoleId])->get();
            foreach($users as $user){
                $dataArray = [
                    "user_id" =>  $user->id,
                    "user_name" => $user->full_name,
                    "link_to_meeting" => "/join_online_meeting_room/".$user->full_name."/".$user->id,
                ];
                array_push($userNames,$dataArray);
            }
        }
        else{
            $dataArray = [
                "user_id" =>  $user->id,
                "user_name" => $user->full_name,
                "link_to_meeting" => "/join_online_meeting_room/".$user->full_name."/".$user->id,
            ];
            array_push($userNames,$dataArray);
        }
        return response()->json(['userNames'=> $userNames],200);
    }

    public function joinOnlineMeetingRoom($userName,$userId, GoogleMeetLink $googleMeetLink){
        $user = Auth::user();
        $role = $user->role->role;

        if($role == "admin" || $role == "teacher"){
            $googleHangoutLink = Configuration::where('key', 'google_meet_id')->value('value');
            if($googleHangoutLink  == null || $googleHangoutLink == ""){
                $googleHangoutLink = $googleMeetLink->generateGoogleMeetLink($userName);
                $configuration = Configuration::where('key', 'google_meet_id')->first();
                $configuration->value = $googleHangoutLink;
                $configuration->save();
            }
            return Redirect::to($googleHangoutLink);
        }
        else{        
            $googleHangoutLink = User::where('id', $userId)->value('classroom_link');
            
            if($googleHangoutLink  == null || $googleHangoutLink == ""){
                $googleHangoutLink = $googleMeetLink->generateGoogleMeetLink($userName);
                $user = User::where('id', $userId)->first();
                $user->classroom_link = $googleHangoutLink;
                $user->save();
            }
        
            return Redirect::to($googleHangoutLink);
        }
    }

    public function createMeetingLinkForStudent(Request $request, GoogleMeetLink $googleMeetLink){
        $studentName = User::where('id',$request->student_id)->value('full_name');
        $googleHangoutLink = $googleMeetLink->generateGoogleMeetLink($studentName);
        $user = User::where('id', $request->student_id)->first();
        $user->classroom_link = $googleHangoutLink;
        $user->save();
        return response()->json(['success'=> "Meet link has been generated/refreshed"],200);
    }

    public function createMeetingLinkForTeachersAndAdmins(){
        $user = Auth::user();
        $role = $user->role->role;

        if($role == "admin" || $role == "teacher"){
            $googleHangoutLink = User::where('id', $userId)->value('classroom_link');
        
            if($googleHangoutLink  == null || $googleHangoutLink == ""){
                $googleHangoutLink = $googleMeetLink->generateGoogleMeetLink($userName);
                $user = User::where('id', $userId)->first();
                $user->classroom_link = $googleHangoutLink;
                $user->save();
            }
          
            return Redirect::to($googleHangoutLink);
        }
    }
}
