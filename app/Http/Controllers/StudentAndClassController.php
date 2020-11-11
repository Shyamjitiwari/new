<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Topic;
use App\Teacher;
use App\Location;
use App\TaskClass;
use Carbon\Carbon;
use App\Helper\Helper;
use App\Mail\NotesToTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Country;

class StudentAndClassController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('role:teacher|admin');
    }
    public function getStudentByFullName(Request $request){
        $roleId = Role::where('role','student')->value('id');
        $studentData = User::where('full_name','like' ,"%".$request->full_name."%")
                        ->where('is_deleted', 0)
                        ->where('role_id', $roleId)
                        ->get();
        $students = array();
        foreach($studentData as $student){
            $country_id = $student['country_id'];
            $calling_code = Country::where('id', $country_id)->value('calling_code');
            $phoneNumberWithCallingCode = $calling_code.$student['phone_number'];
            $dataArray = ["student_id" => $student['id'],
                      "link_to_profile" => "/edit_student_profile/".$student['id'],
                      "student_name" => $student['full_name']." - (".$calling_code.")".$student['phone_number'],
                      "student_phonenumber" => $phoneNumberWithCallingCode,
            ];
            array_push($students,$dataArray);
        }
        if(count($students) <= 0){
            return response()->json(['response_msg'=>'No Student exists with this information'],200);
        }
        else{
            return response()->json(['students'=> $students],200);
        }
    }

    public function getStudentByPhoneNumber(Request $request){
        $roleId = Role::where('role','student')->value('id');
        $phoneNumber = $request->phone_number;

        $studentData = User::where(['phone_number' => $phoneNumber,
                                    'is_deleted' => false,
                                    'role_id' => $roleId])->get();
        $students = array();
        foreach($studentData as $student){
            $countryId = $student['country_id'];
            $calling_code = Country::where('id', $countryId)->value('calling_code');
            $phoneNumberWithCallingCode = $calling_code.$student['phone_number'];
            $dataArray = ["student_id" => $student['id'],
                      "link_to_profile" => "/edit_student_profile/".$student['id'],
                      "student_name" => $student['full_name']." - (".$calling_code.")".$student['phone_number'],
                      "student_phonenumber" => $phoneNumberWithCallingCode,
            ];
            array_push($students,$dataArray);
        }
        if(count($students) <= 0){
            return response()->json(['response_msg'=>'No Student exists with this information'],200);
        }
        else{
            return response()->json(['students'=> $students],200);
        }
    }

    public function getStudentByEmailId(Request $request){
        $studentRoleId = Role::where('role','student')->value('id');
        $emailId = $request->email_id;

        $studentData = User::where(['email' => $emailId,
                                    'is_deleted' => false,
                                    'role_id' => $studentRoleId])->get();
        $students = array();
        foreach($studentData as $student){
            $countryId = $student['country_id'];
            $calling_code = Country::where('id', $countryId)->value('calling_code');
            $phoneNumberWithCallingCode = $calling_code.$student['phone_number'];
            $dataArray = ["student_id" => $student['id'],
                          "link_to_profile" => "/edit_student_profile/".$student['id'],
                          "student_name" => $student['full_name']." - (".$calling_code.")".$student['phone_number'],
                          "student_phonenumber" => $phoneNumberWithCallingCode,
            ];
            array_push($students,$dataArray);
        }
        if(count($students) <= 0){
            return response()->json(['response_msg'=>'No Student exists with this information'],200);
        }
        else{
            return response()->json(['students'=> $students],200);
        }
    }

    public function getStudentProfile(Request $request){
        $student = User::where('id',$request->student_id)->first();
        $topic = $student->topics()->first();
        $calling_code = Country::where('id', $student['country_id'])->value('calling_code');

        $profile = ["student_id" => $student['id'],
                    "full_name" => $student['full_name'],
                    'country_id' => $student['country_id'],
                    'calling_code' => $calling_code,
                    "phone_number" => $student['phone_number'],
                    "email" => $student['email'],
                    "dob" => $student['dob'],
                    "referral" => $student['referral'],
                    "goal" => $student['goal'],
                    "notes" => $student['notes'],
                    "topic_id" => $topic['id'],
                    "topic" => $topic['name'],
                    "meet_link" => $student['classroom_link'],
        ];
        return response()->json(['profile'=> $profile],200);
    }
    public function editStudentAssignmentToClasses($studentId){
        $user = Auth::user();
        $role = $user->role->role;
        if($role == "admin"){
            return view('task_class.admin_edit_student_profile')->withStudent($studentId);
        }
        elseif($role == "teacher"){
            return view('task_class.teacher_edit_student_profile')->withStudent($studentId);
        }
    }

    public function editStudentProfile(Request $request){

        $user = User::where('id', $request->student_id)->first();
        $user->full_name = $request->full_name;
        $user->phone_number = $request->phone_number;
        $user->country_id = $request->country_id;
        $user->email = $request->email;
        $user->dob = $request->dob;
        $user->referral = $request->referral;
        $user->goal = $request->goal;
        $user->notes = $request->notes;
        $user->save();

        if($request->topic_id != null){
            $newTopic = Topic::find($request->topic_id);
            $oldTopic = $user->topics()->first();

            if($oldTopic != null){
                $oldTopic->users()->detach($user);
            }      
            $newTopic->users()->attach($user);
        }
         // if send mail flag is true then process mail request
         if($request->has('sendEmail'))
         {
            $sendStatus = $this->sendEmailToTeacher($user->id, $request->notes);
            if($sendStatus) {
                return response()->json(['response_msg' => 'Data Updated & Email Sent'], 200);
            } else {
                return response()->json(['response_msg' => 'Next class not assigned'], 404);
            }
        }
        
        return response()->json(['response_msg'=>'Data Updated'],200);
    }

    public function sendEmailToTeacher($student_id, $notes)
    {
        //get the next class for this student
        $class = User::find($student_id)
            ->taskclasses()
            ->whereDate('starts_at', '>', Carbon::now())
            ->first();

        if($class)
        {
            //get the email of the teacher of the next class for this student
            $teacher = DB::table('task_class_user as tc')
                ->where('tc.task_class_id', $class->pivot->task_class_id)
                ->join('users as u', 'tc.user_id','=','u.id')
                ->join('roles as r', 'u.role_id', '=', 'r.id')
                ->where('role', 'teacher')
                ->orderBy('tc.id', 'desc')
                ->select('u.*')
                ->first();

            //send mail is a teacher is assigned to the class
            if($teacher)
            {
                Mail::to($teacher->email)->send(new NotesToTeacher($notes, $teacher, $class));
            }
            return true;
        }
        return false;
    }

    public function getStudentsClasses(Request $request)
    {
        $taskClasses = User::find($request->student_id)->taskclasses()->get();
        $classes = array();

        foreach($taskClasses as $taskClass) {
            $teacher = "Un-assigned";
            $usersAttached = $taskClass->users;
            foreach($usersAttached as $user) {
                $role = Role::where('id', $user->role_id)->value('role');
                if($role == "teacher"){
                    $teacher = $user->full_name;
                }
            }
            $timestamp = strtotime($taskClass['starts_at']);
            $time = date('H:i', $timestamp);
            $date = date('d-m-Y',$timestamp);
            $dataArray = [
                    "taskclass_studentid" => $request->student_id,
                    "taskclass_id" => $taskClass['id'],
                    "taskclass_name" => $teacher." - ".$taskClass['name'],
                    "taskclass_date" => $date,
                    "taskclass_time" => $time,
                    "pivot" => $taskClass->users[0]->pivot,
            ];
            array_push($classes, $dataArray);   
        }
        return response()->json(['taskClasses'=> $classes],200);
    }

    public function getIncompleteStudentsClasses(Request $request)
    {
        $incompleteTaskClasses = User::find($request->input('student_id'))->incomplete_taskclasses()->get();

        $incompleteNotAbsentClasses = [];
        foreach($incompleteTaskClasses as $class)
        {
            if(!$class->pivot->absent) {
                $incompleteNotAbsentClasses[] = $class;
            }
        }

        return response()->json(['incompleteTaskClasses'=> $incompleteNotAbsentClasses],200);
    }

    public function unAssignStudent(Request $request)
    {
        DB::table('task_class_user')->where('id', $request->input('pivot')['id'])->delete();
    }

    public function getClassesForStudentLocationAndDate(Request $request){
        $locationData = User::find($request->student_id)->locations()->get();
        $classes = array();
        $classesData = array();
        foreach($locationData as $location){

            if($request->selectedDate != null && $request->selectedDate != ""){
                $classesDataWithoutSelectedDateFilter = TaskClass::where(['is_deleted' => false, 
                                                'location_id' => $location->id,
                                                ])->orderBy('starts_at', 'asc')->get();
                foreach($classesDataWithoutSelectedDateFilter as $classDataWithoutSelectedDateFilter){
                    $startsAtDate = date("Y-m-d", strtotime($classDataWithoutSelectedDateFilter->starts_at));
                    $selectedDate = date("Y-m-d", strtotime($request->selectedDate));
                    if( $startsAtDate == $selectedDate){
                        array_push($classesData, $classDataWithoutSelectedDateFilter);
                    }
                }
            }
            else{
                $classesDataWithoutDate = TaskClass::where(['is_deleted' => false, 
                                                'is_completed' => false,
                                                'location_id' => $location->id ])
                                                ->orderBy('starts_at', 'asc')->get();
                foreach($classesDataWithoutDate as $classDataWithoutDate){
                    array_push($classesData, $classDataWithoutDate);
                }
            }

        }
        foreach($classesData as $data){
            $teacher = "Un-assigned";
            $usersAttached = $data->users;
            foreach($usersAttached as $user){
                $role = Role::where('id', $user->role_id)->value('role');
                if($role == "teacher"){
                    $teacher = $user->full_name;
                }
            }
            $recurring = $data['recurring'] ? 'Recurring' : 'Not Recurring';
            $timestamp = strtotime($data['starts_at']);
            $time = date('g:i A', $timestamp);
            $dataArray = [
                    "taskclass_id" => $data['id'],
                    "taskclass_name" => $time." - ".$teacher."-".$data['name']."-".$recurring,
                    "taskclass_starting_datetime" => $data['starts_at'],
                    "taskclass_ending_datetime" => $data['ends_at'],
            ];
            array_push($classes,$dataArray);      
        }     
        if(count($classes) <= 0){
            return response()->json(['response_msg'=>'No Classes exist for this Information'],200);
        }
        else{
            return response()->json(['classes'=> $classes],200);
        } 
    }


    public function getClassesForNewStudentLocationAndDate(Request $request){
        $locationData = Location::where("id",$request->location_id)->get();
        $classes = array();
        $classesData = array();
        foreach($locationData as $location){

            if($request->selectedDate != null && $request->selectedDate != ""){
                $classesDataWithoutSelectedDateFilter = TaskClass::where(['is_deleted' => false, 
                                                'location_id' => $location->id,
                                                ])->orderBy('starts_at', 'asc')->get();
                foreach($classesDataWithoutSelectedDateFilter as $classDataWithoutSelectedDateFilter){
                    $startsAtDate = date("Y-m-d", strtotime($classDataWithoutSelectedDateFilter->starts_at));
                    $selectedDate = date("Y-m-d", strtotime($request->selectedDate));
                    if( $startsAtDate == $selectedDate){
                        array_push($classesData, $classDataWithoutSelectedDateFilter);
                    }
                }
            }
            else{
                $classesDataWithoutDate = TaskClass::where(['is_deleted' => false, 
                                                'is_completed' => false,
                                                'location_id' => $location->id ])
                                                ->orderBy('starts_at', 'asc')->get();
                foreach($classesDataWithoutDate as $classDataWithoutDate){
                    array_push($classesData, $classDataWithoutDate);
                }
            }

        }
        foreach($classesData as $data){
            $teacher = "Un-assigned";
            $usersAttached = $data->users;
            foreach($usersAttached as $user){
                $role = Role::where('id', $user->role_id)->value('role');
                if($role == "teacher"){
                    $teacher = $user->full_name;
                }
            }
            $recurring = $data['recurring'] ? 'Recurring' : 'Not Recurring';
            $timestamp = strtotime($data['starts_at']);
            $time = date('g:i A', $timestamp);
            $dataArray = [
                    "taskclass_id" => $data['id'],
                    "taskclass_name" => $time."-".$teacher."-".$data['name']."-".$recurring,
                    "taskclass_starting_datetime" => $data['starts_at'],
                    "taskclass_ending_datetime" => $data['ends_at'],
            ];
            array_push($classes,$dataArray);      
        }     
        if(count($classes) <= 0){
            return response()->json(['response_msg'=>'No Classes exist for this Information'],200);
        }
        else{
            return response()->json(['classes'=> $classes],200);
        } 
    }

    public function getTeachersForTheLocation(Request $request)
    {
        $userData = Location::find($request->location_id)->users()->get();
        $teachers = array();

        foreach($userData as $user)
        {
            $roleId = Role::where('role','teacher')->value('id');
            $teacherData = User::where([ 'id' => $user->id,
                                         'is_deleted' => false, 
                                         'role_id' => $roleId, ])->get();
            foreach($teacherData as $teacher){
                $dataArray = ["teacher_id" => $teacher['id'],
                              "teacher_name" => $teacher['full_name'],
                ];
                array_push($teachers,$dataArray);           
            }
        }

        if(count($teachers) <= 0)
        {
            return response()->json(['response_msg'=>'No teachers found for this location.'],200);
        } else {
            return response()->json(['teachers'=> $teachers],200);
        }
    }

    public function addTaskClass(Request $request)
    {
        $this->createTaskClass($request);

        return response()->json(['response_msg'=>'Data saved'],200);
    }

    // this function is also being called from CampController to make all task classes related with camps
    public function createTaskClass($data)
    {
        $start_time = date("H:i:s", strtotime($data->startingDatetime));
        $end_time = date("H:i:s", strtotime($data->endingDatetime));
        $camp = $data->camp;

        $className = $data->taskclass_name;
        $teacherId = $data->teacher_id;
        $locationId = $data->location_id;
        $classStartingdatetime = date("Y-m-d H:i:s", strtotime($data->startingDatetime));
        $classEndingdatetime = date("Y-m-d H:i:s", strtotime($data->endingDatetime));
        $topicIds = $data->topics;
        $ages = $data->ages;

        $taskClass = new TaskClass();
        $taskClass->name = $className;
        $taskClass->student_limit = $data->student_limit;
        $taskClass->location_id = $locationId;
        $taskClass->is_completed = false;
        $taskClass->starts_at = $classStartingdatetime;
        $taskClass->ends_at = $classEndingdatetime;
        $taskClass->camp_id = $camp ? $camp['id'] : null;
        $taskClass->task_class_type_id = $data->task_class_type_id;
        $taskClass->is_free_session = $data->isFreeSessionClass;
        $taskClass->recurring = $data->recurring;
        $taskClass->save();

        $user = User::find($teacherId);
        $taskClass->users()->attach($user);
        $taskClass->topics()->sync($topicIds);
        $taskClass->ages()->sync($ages);

        if($data->repeats) {
            foreach ($data->repeats as $date) {
                $className = $data->taskclass_name;
                $teacherId = $data->teacher_id;
                $locationId = $data->location_id;
                $classStartingdatetime = Carbon::parse($date.$start_time);
                $classEndingdatetime = Carbon::parse($date.$end_time);
                $topicIds = $data->topics;
                $ages = $data->ages;

                $taskClass = new TaskClass();
                $taskClass->name = $className;
                $taskClass->location_id = $locationId;
                $taskClass->is_completed = false;
                $taskClass->starts_at = $classStartingdatetime;
                $taskClass->ends_at = $classEndingdatetime;
                $taskClass->camp_id = $camp ? $camp['id'] : null;
                $taskClass->task_class_type_id = $data->task_class_type_id;
                $taskClass->is_free_session = $data->isFreeSessionClass;
                $taskClass->recurring = $data->recurring;
                $taskClass->save();

                $user = User::find($teacherId);
                $taskClass->users()->attach($user);
                $taskClass->topics()->sync($topicIds);
                $taskClass->ages()->sync($ages);
            }
        }
    }
 
    public function addStudentToClass(Request $request)
    {
        $user = User::find($request->selectedStudentId);
        $taskClass = TaskClass::find($request->selectedClassId);

        //check if use is already attached to the class
        $isPresent = DB::table('task_classes as tc')
            ->join('task_class_user as tcu','tc.id','=','tcu.task_class_id')
            ->where('tcu.user_id', $user->id)
            ->where('tcu.task_class_id', $taskClass->id)
            ->count();

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

        if(!$isPresent)
        {
             $taskClass->users()->attach($user, ['free' => $free, 'recurring' => $request->recurring, 'first' => $first]);
            return response()->json(['response_msg'=>'Data saved'],200);
        } else {
            return response()->json(['response_msg'=>'Class already assigned'],404);
        }
    }
    
    public function checkIfFirstClass(Request $request)
    {
        $student = User::find($request->student_id);
        return $student->first_taskckass->count();
    }
    
    public function addTaskClassForm(){
        $user = Auth::user();
        $role = $user->role->role;
        if($role == "admin"){
            return view('task_class.admin_add_class_form');
        }
        elseif($role == "teacher"){
            return view('task_class.teacher_add_class_form');
        }
    }

    public function addStudentForm(){
        $user = Auth::user();
        $role = $user->role->role;
        if($role == "admin"){
            return view('task_class.admin_add_students_form');
        }
        elseif($role == "teacher"){
            return view('task_class.teacher_add_students_form');
        }
    }

    public function addLocationToStudent(Request $request){
        $user = User::find($request->selectedStudentId);
        $location = Location::find($request->selectedLocationId);
        if( $user->locations->contains($location->id)){
            return response()->json(['response_msg'=>'You cannot add duplicate location.'],200);
        }
        else{
            $location->users()->attach($user);
            return response()->json(['response_msg'=>'Data saved'],200);
        } 
    }

    public function getStudentsLocations(Request $request){
        $locationData = User::find($request->student_id)->locations()->get();
        $locations = array();
        foreach($locationData as $location){
            $dataArray = [
                    "student_id" => $request->teacher_id,
                    "location_id" => $location['id'],
                    "location_name" => $location['location_name'],
            ];
            array_push($locations,$dataArray);   
        }
        return response()->json(['student_locations'=> $locations],200);
    }

    public function removeStudentLocation(Request $request){
        $locationData = User::find($request->student_id)->locations()->get();
        if(count($locationData) <= 1){
            return response()->json(['response_msg'=>'You can not delete this location.'],200);
        }
        else{
            $user = User::find($request->student_id);
            $location = Location::find($request->selectedLocationId);
            $location->users()->detach($user);
            return response()->json(['response_msg'=>'Data deleted'],200);
        }
    }

    
    public function getCompletedClasses(Request $request)
    {
        $completedClasses = User::find($request->input('student_id'))->completed_taskclasses()->get();
        $absentClasses = User::find($request->input('student_id'))->absent_taskclasses()->get();

        $data = array();
        foreach($completedClasses as $completedClass) {
            $data['classes'][] = $completedClass;
        }

        $data['completed_taskclasses_count'] = User::find($request->input('student_id'))->completed_taskclasses()->count();

        foreach($absentClasses as $absentClass) {
            $data['classes'][] = $absentClass;
        }
        $data['absent_taskclasses_count'] = User::find($request->input('student_id'))->absent_taskclasses()->count();


        return response()->json(['completedClasses'=> $data, 'message' => null, 'status'=>'success'],200);
    }

//    public function getAllStudentForTaskClass($id)
//    {
//        $taskClasses = DB::table('task_classes as tc')
//            ->join('task_class_user as tcu', 'tc.id', '=', 'tcu.task_class_id')
//            ->join('users as u', 'u.id', '=', 'tcu.user_id')
//            ->join('roles as r', 'r.id', '=', 'u.role_id')
//            ->join('topic_user', 'u.id','=','topic_user.user_id')
//            ->join('topics as t', 't.id','=','topic_user.topic_id')
//            ->leftjoin('users as p', 'p.phone_number', '=', 'u.phone_number')
//            ->leftjoin('surveys as s', function($join) {  $join->on('s.user_id', '=', 'p.id')
//                ->on('s.id', '=', DB::raw("(SELECT max(id) from surveys WHERE surveys.user_id = p.id)"));
//              })
//            ->leftjoin('updates as up', function($join) {  $join->on('up.user_id', '=', 'u.id')
//                ->on('up.id', '=', DB::raw("(SELECT max(id) from updates WHERE updates.user_id = u.id)"));
//              })
//            ->where('r.id', 4)
//            ->where('tcu.completed', 0)
//            ->where('tcu.absent', 0)
//            ->where('tc.is_deleted', 0)
//            ->where('tc.id', $id)
//            ->where('p.role_id',3)
//            ->select('u.*','s.*','up.*','tcu.id as pivot_id', 'tcu.completed as pivot_completed', 'tcu.absent as pivot_absent', 't.name as topic_name', 'u.id as id')
//            ->get();
//
////        foreach($taskClasses as $index => $taskClass)
////        {
////            $taskClasses[$index]->user_name = Helper::truncateName($taskClass->user_name) . ' - ' .$taskClass->topic_name;
////        }
//
//        return response()->json(['taskClasses'=> $taskClasses, 'message' =>  null, 'status'=>'success'],200);
//    }

    public function pingParent(Request $request)
    {
        $student = User::find($request->input('student_id'));

        $msg = "Hello, this is an automated text from Code With Us to inform you that we currently do not see ". Helper::truncateName($student->user_name) ." in class scheduled for right now. Please call or text us if there is a problem accessing the classroom, or if you'd like to reschedule.";

        if($student->phone_number != null ){
            $callingCode = Country::where('id', $student->country_id)->value('calling_code');
            $phoneNumberWithCountryCallingCode = $callingCode.$student->phone_number;
            Helper::sendSMS($msg,$phoneNumberWithCountryCallingCode);
        }
        //$student->phone_number ? Helper::sendSMS($msg,$student->phone_number) : null;

        return response()->json(['data'=> null, 'message' => 'Successfully pinged student', 'status'=>'success'],200);
    }

    public function archiveStudent(Request $request)
    {
        $student = User::find($request->input('student_id'));

        $student->is_deleted = 1;
        $student->save();

        return response()->json(['data'=> null, 'message' => 'Student archived', 'status'=>'success'],200);
    }

    public function updateStudentTopic(Request $request)
    {
        $user = User::find($request->student_id);
        $topic = Topic::find($request->topic_id);
        //remove old topic
        $user->topics()->detach();
        //add new topic
        $user->topics()->attach($topic);

        return response()->json(['data'=> null, 'message' => 'Topic updated', 'status'=>'success'],200);
    }



}
