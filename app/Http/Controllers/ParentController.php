<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Update;
use App\User;
use App\Role;
use Auth;
use App\Location;
use App\Country;
use App\Credit;

class ParentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:parent|admin');
    }
    public function index()
    {
        return view('parent.index');
    }
    public function updates(){
        $phoneNumber = auth()->user()->phone_number;
        $updatesData = Update::where('phone_number', $phoneNumber)->orderBy('created_at','desc')->get();
        $updates = array();
        foreach($updatesData as $update){
            $userName = User::where('id', $update->user_id)->value('full_name');
            $isTeacher = $update->is_teacherOrAdmin;

            if($isTeacher){
                $created_by = "Teacher: ".$userName;
                $dataArray = ["id" => $update->id,
                              "content" =>  $update->content,
                              "created_at" => $update->created_at,
                              "created_by" => $created_by
                ];
                array_push($updates,$dataArray);
            }
            else{
                $created_by = "Student: ".$userName;
                $dataArray = ["id" => $update->id,
                              "content" =>  $update->content,
                              "created_at" => $update->created_at,
                              "created_by" => $created_by
                ];
                array_push($updates,$dataArray);
            }
        }
        return view("parent.updates",compact('updates'));
    }

    public function getParentByPhoneNumber(Request $request){
        $roleId = Role::where('role','parent')->value('id');
        $phoneNumber = $request->phone_number;

        $parentData = User::where(['phone_number' => $phoneNumber,
                                    'is_deleted' => false,
                                    'role_id' => $roleId])->get();
        $parents = array();
        foreach($parentData as $parent){
            $countryId = $parent['country_id'];
            $calling_code = Country::where('id', $countryId)->value('calling_code');
            $dataArray = ["parent_id" => $parent['id'],
                          "link_to_profile" => "/get_parent_profile/".$parent['id'],
                          "parent_name" => $parent['email']." - (".$calling_code.")".$parent['phone_number'],
            ];
            array_push($parents,$dataArray);
        }
        if(count($parents) <= 0){
            return response()->json(['response_msg'=>'No Parent exists with this information'],200);
        }
        else{
            return response()->json(['parents'=> $parents],200);
        }
    }

    public function getParentByEmailId(Request $request){
        $roleId = Role::where('role','parent')->value('id');
        $emailId = $request->email_id;

        $parentData = User::where(['email' => $emailId,
                                    'is_deleted' => false,
                                    'role_id' => $roleId])->get();
        $parents = array();
        foreach($parentData as $parent){
            $countryId = $parent['country_id'];
            $calling_code = Country::where('id', $countryId)->value('calling_code');
            $dataArray = ["parent_id" => $parent['id'],
                          "link_to_profile" => "/get_parent_profile/".$parent['id'],
                          "parent_name" => $parent['email']." - (".$calling_code.")".$parent['phone_number'],
            ];
            array_push($parents,$dataArray);
        }
        if(count($parents) <= 0){
            return response()->json(['response_msg'=>'No Parent exists with this information'],200);
        }
        else{
            return response()->json(['parents'=> $parents],200);
        }
    }

    public function searchParentProfileForm(){
        $user = Auth::user();
        $role = $user->role->role;
        if($role == "admin"){
            return view('parent.admin_search_parent_profile');
        }
        elseif($role == "teacher"){
            return view('parent.teacher_search_parent_profile');
        }
    }

    public function getParentProfile($parentId){
        $user = Auth::user();
        $role = $user->role->role;

        $user = User::where('id',$parentId)->first();
        $parentEmailId = $user->email;
        $parentPhoneNumber = $user->phone_number;
        if($parentEmailId != null && $parentEmailId != ""){
            $getPaymentsMade = Credit::where(['customer_email' => $user->email])->get();
        }else{
            $getPaymentsMade = Credit::where(['phone_number' => $user->phone_number])->get();
        }
        
        $totalCreditsGiven = 0.0;
        foreach($getPaymentsMade as $getPaymentMade){
            $totalCreditsGiven += $getPaymentMade->credits_given;
        }
       
        $studentRoleId = Role::where('role','student')->value('id');
        $creditsUsed = DB::table('users as u')
                        ->join('task_class_user as tcu','tcu.user_id','=','u.id')
                        ->where('u.phone_number',$parentPhoneNumber)
                        ->where('u.role_id',$studentRoleId)
                        ->where('tcu.completed',1)
                        ->select('tcu.*')
                        ->select(DB::raw("count(tcu.completed) as credits_used"))
                        ->groupBy('u.id')
                        ->get();

        $credits_used = 0;
        foreach($creditsUsed as $creditUsed){
            $credits_used += $creditUsed->credits_used;
        }
        $remaining_credits = $totalCreditsGiven -  $credits_used;

        if($role == "admin"){
            return view('parent.admin_selected_parent_profile')->withParent($parentId)
                                                               ->withCreditsused($credits_used)
                                                               ->withCreditsremaining($remaining_credits);
        }
        elseif($role == "teacher"){
            return view('parent.teacher_selected_parent_profile')->withParent($parentId)
                                                                ->withCreditsused($credits_used)
                                                                ->withCreditsremaining($remaining_credits);
        }
    }

    public function studentsListPage(){
        return view('parent.students');
    }
    public function getStudentsList($parentId = null){
        /*
        * If the value of $parentId is null, it means a loggedIn Parent wants to
        * retrieve list of his students. But if it's not null, it means an Admin or 
        * teacher is trying to get list of students for a particular parent by passing
        * his/her id. 
        */
        if($parentId != null){
            $user = User::find($parentId);
        }else{
            $user = Auth::user();
        } 
        $roleId = Role::where('role', 'student')->value('id');
        $phoneNumber = $user->phone_number;
        $users = User::where(['phone_number' => $phoneNumber,
                              'role_id' => $roleId])->get();
        $students = array();
        foreach($users as $user){
            $completed_classes = $user->completed_taskclasses()->get();
            $credits_used = count($completed_classes);
            $locations = $user->locations()->get();
            foreach($locations as $location){
                $dataArray = ["id" => $user->id,
                              "student_name" =>  $user->full_name,
                              "location" => $location->location_name,
                              "credits_used" => $credits_used
                ];
                array_push($students,$dataArray);
            }
        }
        return response()->json(['students'=> $students],200);
    }
}
