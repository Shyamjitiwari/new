<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Location;
use Auth;
use App\Topic;
use App\TaskClass;
use App\Country;
use App\Timezone;

class AddStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|teacher|parent');
    }

    public function addStudentForm(){
        $user = Auth::user();
        $role = $user->role->role;
        if($role == "admin"){
            return view('add_students.admin_add_student_form');
        }
        else if($role == "teacher"){
            return view('add_students.teacher_add_student_form');
        }
        else if($role == "parent"){
            return view('add_students.parent_add_student_form');
        }
    }

    public function getParentsPhoneNumber(){
        $user = Auth::user();
        $role = $user->role->role;
        if($role == "parent"){
            $phoneNumber = $user->phone_number;
            $country_id = $user->country_id;
            return response()->json(['phoneNumber'=> $phoneNumber,'countryId' => $country_id],200);
        }
        else{
            return response()->json(['response_msg'=>'Not a Parent'],200);
        }
    }

    public function getLocations(){
        $user = Auth::user();
        $role = $user->role->role;
        $locations = array();
        if($role == "parent" || $role == "admin"){
            $locationsData = Location::where('is_deleted',false)->get();
            foreach( $locationsData as $location){
                $dataArray = ["location_id" => $location['id'],
                              "location_name" => $location['location_name'],                
                ];
                array_push($locations,$dataArray);
            }
        }
        else if($role == "teacher"){
            $locationsData = $user->locations()->get();
            foreach( $locationsData as $location){
                $dataArray = ["location_id" => $location['id'],
                              "location_name" => $location['location_name'],                
                ];
                array_push($locations,$dataArray);
            }
        }
        return response()->json(['locations'=> $locations],200);
    }

    public function getTimezones(){
        //$timezones = Timezone::orderBy('gmt_offset', 'asc')->get();
        $timezones = Timezone::all();
        return response()->json(['timezones'=> $timezones],200);
    }

    public function addStudent(Request $request){
        $roleId = Role::where('role', 'student')->value('id');
        $countryName = Country::where('calling_code',$request->country_id)->value('country_name');

        $duplicateUserName = User::where('user_name', $request->input('full_name'))->first();
        $student_name = $request->input('full_name');
        $student_full_name = $request->input('full_name');

        $existingUser = User::where('user_name', $request->input('full_name'))
            ->where('phone_number', $request->input('phone_number'))
            ->first();

        if($existingUser)
        {
            return response()->json(['response_msg'=>$request->input('full_name'). ' is already registered under this parent'],404);
        }

        if($duplicateUserName && $existingUser == null)
        {
            $student_name = Helper::generateUniqueFieldValue('users','user_name',$request->input('full_name'),2);
        }

        $user = new User();
        $user->user_name = $student_name;
        $user->full_name = $student_full_name;
        $user->phone_number = $request->phone_number;
        $user->dob = $request->dob;
        $user->email = $request->email;
        $user->country_id = $request->country_id;
        $user->notes = $request->notes;
        $user->role_id = $roleId;
        $user->timezone_id = $request->timezone_id;
        $user->referral = $request->referral;
        $user->goal = $request->goal;
        $user->save();

        $parentRoleId = Role::where('role', 'parent')->value('id');

        $findParentIfExists = User::where(['phone_number' => $request->phone_number,
                                           'role_id' => $parentRoleId])->first();
        if($findParentIfExists == null){
            $parent = new User();
            $parent->user_name = $request->phone_number;
            $parent->phone_number = $request->phone_number;
            $parent->country_id = $request->country_id;
            $parent->email = $request->email;
            $parent->role_id = $parentRoleId;
            $parent->password = bcrypt("pass");
            $parent->timezone_id = $request->timezone_id;
            $parent->save();
        }
        
        // Attaching the user to the selected Location
        $location = Location::find($request->location_id);
        $location->users()->attach($user);

        // Attaching the user to the selected Main Topic
        if($request->topic_id != null && $request->topic_id != ""){
            $newTopic = Topic::find($request->topic_id);    
            $newTopic->users()->attach($user);
        }

        if(!$request->freeorfirst) {
            $free = false;
            $first = false;
        } else if ($request->freeorfirst == 'free') {
            $free = true;
            $first = false;
        } else {
            $free = false;
            $first = true;
        }
      
        // Attaching the user to the selected Task Class
        if($request->task_class_id != null && $request->task_class_id != ""){
            $taskClass = TaskClass::find($request->task_class_id);
            $taskClass->users()->attach($user, ['free' => $free, 'recurring' => $request->recurring, 'first' => $first]);
        }

        return response()->json(['response_msg'=>'Student Added'],200);
    }
}
