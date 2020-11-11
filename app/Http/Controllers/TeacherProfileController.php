<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskClass;
use App\Teacher;
use App\User;
use App\Role;
use App\Location;
use App\Topic;
use App\Country;

class TeacherProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|teacher');
    }

    public function searchTeachers(){
        return view('admin.search_teacher');
    }

    public function getTeacherByPhoneNumber(Request $request){
        $roleId = Role::where('role','teacher')->value('id');
        $teacherData = User::where(['phone_number' => $request->phone_number,
                                    'is_deleted' => false,
                                    'role_id' => $roleId])->get();
        $teachers = array();
        foreach($teacherData as $teacher){
            $country_id =  $teacher['country_id'];
            $calling_code = Country::where('id', $country_id)->value('calling_code');
            $phoneNumberWithCallingCode = $calling_code.$teacher['phone_number'];
            $dataArray = ["teacher_id" => $teacher['id'],
                      "link_to_profile" => "/edit_teacher_profile/".$teacher['id'],
                      "teacher_name" => $teacher['full_name']." - (".$calling_code.")".$teacher['phone_number'],
                      "teacher_phonenumber" => $phoneNumberWithCallingCode,
            ];
            array_push($teachers,$dataArray);
        }
        if(count($teachers) <= 0){
            return response()->json(['response_msg'=>'No Teacher exists with this information'],200);
        }
        else{
            return response()->json(['teachers'=> $teachers],200);
        }
    }

    public function getTeacherByFullName(Request $request){
        $roleId = Role::where('role','teacher')->value('id');
        $teacherData = User::where('full_name' ,'like' ,"%".$request->full_name."%")->where([
                                    'is_deleted' => false,
                                    'role_id' => $roleId])->get();
        $teachers = array();
        foreach($teacherData as $teacher){
            $country_id =  $teacher['country_id'];
            $calling_code = Country::where('id', $country_id)->value('calling_code');
            $phoneNumberWithCallingCode = $calling_code.$teacher['phone_number'];
            $dataArray = ["teacher_id" => $teacher['id'],
                      "link_to_profile" => "/edit_teacher_profile/".$teacher['id'],
                      "teacher_name" => $teacher['full_name']." - (".$calling_code.")".$teacher['phone_number'],
                      "teacher_phonenumber" => $phoneNumberWithCallingCode,
            ];
            array_push($teachers,$dataArray);
        }
        if(count($teachers) <= 0){
            return response()->json(['response_msg'=>'No Teacher exists with this information'],200);
        }
        else{
            return response()->json(['teachers'=> $teachers],200);
        }
    }
    public function getTeacherByEmail(Request $request){
        $roleId = Role::where('role','teacher')->value('id');
        $teacherData = User::where(['email' => $request->email,
                                    'is_deleted' => false,
                                    'role_id' => $roleId])->get();
        $teachers = array();
        foreach($teacherData as $teacher){
            $country_id =  $teacher['country_id'];
            $calling_code = Country::where('id', $country_id)->value('calling_code');
            $phoneNumberWithCallingCode = $calling_code.$teacher['phone_number'];
            $dataArray = ["teacher_id" => $teacher['id'],
                      "link_to_profile" => "/edit_teacher_profile/".$teacher['id'],
                      "teacher_name" => $teacher['full_name']." - (".$calling_code.")".$teacher['phone_number'],
                      "teacher_phonenumber" => $phoneNumberWithCallingCode,
            ];
            array_push($teachers,$dataArray);
        }
        if(count($teachers) <= 0){
            return response()->json(['response_msg'=>'No Teacher exists with this information'],200);
        }
        else{
            return response()->json(['teachers'=> $teachers],200);
        }
    }

    public function getTeachersLocations(Request $request){
        $locationData = User::find($request->teacher_id)->locations()->get();
        $locations = array();
        foreach($locationData as $location){
            $dataArray = [
                    "teacher_id" => $request->teacher_id,
                    "location_id" => $location['id'],
                    "location_name" => $location['location_name'],
            ];
            array_push($locations,$dataArray);   
        }
        return response()->json(['teacher_locations'=> $locations],200);
    }
    public function getTeachersTopics(Request $request){
        $topicData = User::find($request->teacher_id)->topics()->get();
        $topics = array();
        foreach($topicData as $topic){
            $dataArray = [
                    "teacher_id" => $request->teacher_id,
                    "topic_id" => $topic['id'],
                    "topic_name" => $topic['name'],
            ];
            array_push($topics,$dataArray);   
        }
        return response()->json(['teacher_topics'=> $topics],200);
    }

    public function addTopicToTeacher(Request $request){
        $user = User::find($request->selectedTeacherId);
        $topic = Topic::find($request->selectedTopicId);
        if( $user->topics->contains($topic->id)){
            return response()->json(['response_msg'=>'You cannot add duplicate topic.'],200);
        }
        else{
            $topic->users()->attach($user);
            return response()->json(['response_msg'=>'Data saved'],200);
        } 
    }

    public function getAllLocations(){
        $locationData = Location::where('is_deleted', false)->get();
        
        $locations = array();
        foreach($locationData as $location){
            $dataArray = ["location_id" => $location['id'],
                      "location_name" => $location['location_name'],
            ];
            array_push($locations,$dataArray);           
        }
        return response()->json(['locations'=> $locations],200);
    }

    public function removeTeacherTopic(Request $request){
        $user = User::find($request->teacher_id);
        $topic = Topic::find($request->selectedTopicId);
        $topic->users()->detach($user);
        return response()->json(['response_msg'=>'Data deleted'],200);
    }

    public function removeTeacherLocation(Request $request){
        $locationData = User::find($request->teacher_id)->locations()->get();
        if(count($locationData) <= 1){
            return response()->json(['response_msg'=>'You can not delete this location.'],200);
        }
        else{
            $user = User::find($request->teacher_id);
            $location = Location::find($request->selectedLocationId);
            $location->users()->detach($user);
            return response()->json(['response_msg'=>'Data deleted'],200);
        }
    }
    public function addLocationToTeacher(Request $request){
        $user = User::find($request->selectedTeacherId);
        $location = Location::find($request->selectedLocationId);
        if( $user->locations->contains($location->id)){
            return response()->json(['response_msg'=>'You cannot add duplicate location.'],200);
        }
        else{
            $location->users()->attach($user);
            return response()->json(['response_msg'=>'Data saved'],200);
        } 
    }
    public function editTeacherProfileForm($teacherId){
        return view('admin.edit_teacher_profile')->withTeacher($teacherId);
    }
    public function editTeacherProfile(Request $request){
        $user = User::where('id', $request->teacher_id)->first();
        $user->phone_number = $request->phone_number;
        $user->country_id = $request->country_id;
        $user->email = $request->email;
        //$user->topic_id = $request->topic_id;
        $user->notes = $request->notes;
        $user->save();
        return response()->json(['response_msg'=>'Data Updated'],200);
    }
    public function getTeacherProfile(Request $request){
        $teacher = User::where('id',$request->teacher_id)->first();
        $topic = Topic::where('id',$teacher['topic_id'])->value('name');
        $calling_code = Country::where('id', $teacher['country_id'])->value('calling_code');

        $profile = ["teacher_id" => $teacher->id,
                    "full_name" => $teacher->full_name,
                    'country_id' => $teacher['country_id'],
                    'calling_code' => $calling_code,
                    "phone_number" => $teacher->phone_number,
                    "email" => $teacher->email,
                    "notes" => $teacher->notes,
                    "topic_id" => $teacher->topic_id,
                    "topic" => $topic,
        ];
        return response()->json(['profile'=> $profile],200);
    }

}

