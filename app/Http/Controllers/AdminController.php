<?php

namespace App\Http\Controllers;

use App\FreeSessionTimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Update;
use PDO;
use Torann\LaravelAsana\Facade\Asana;
use Illuminate\Support\Facades\DB;
use App\TaskClass;
use App\Teacher;
use App\User;
use App\Role;
use App\Location;
use App\Topic;
use App\Day;
use App\Time;
use App\FreeSessionBooking;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    public function index()
    {
        return view('admin.index');
    }

    public function newUpdateForm($taskId=null){
        if($taskId != null){
            return view('admin.update')->withTaskid($taskId);
        }
        else{
            return view('admin.update')->withTaskid("");
        }
    }
    public function writeAnUpdate(Request $request){
        // When an admin writes an update, we should get the phone number from the task data
        // Right now, its dummy
        $userId = auth()->user()->id;
        $content = $request->input('content');
        $teacherOrAdminName = auth()->user()->user_name;
        if($request->taskId == null){
            Update::create([  
                'user_id' => $userId,
                'is_teacherOrAdmin' => true,
                'content' => $content,
            ]);
        }
        else{
            $task = Asana::getTask($request->taskId);
            $projectName = $task->data->projects[0]->name;
            $phoneNumber = $this->get_string_between($projectName, '{', '}');
            if($phoneNumber[0] != "+" && $phoneNumber[0] != 1){
                $phoneNumber = "+1".$phoneNumber;
            }
            elseif($phoneNumber[0] != "+" && $phoneNumber[0] == 1){
                $phoneNumber = "+".$phoneNumber;
            }

            $createdUser = Update::create([  
                'phone_number' => $phoneNumber,
                'user_id' => $userId,
                'is_teacherOrAdmin' => true,
                'content' => $content,
            ]);
           
            $student_name = explode (" ", $projectName);
            $textContent = "Teacher/Admin ".$teacherOrAdminName." has written an update for ".$student_name[0]. 
                            ". Click on this link to see it: https://portal.codewithus.com/parent/update/".$phoneNumber."/".$createdUser->id;
            
            // //Start of SMS sending function
            $ch = curl_init();
            $api_key = '23480ecaa2d37d33905eae528df2d19e86c898c4653ec9e73b3d01ba96182f74';
            $headers = array();
            $headers[] = "X-Toky-Key: {$api_key}";
            //{"from":"+16282275444", "to": "+16282275222", "text": "Hello from Toky"}
            $data = array("from" => "+14089097717", "email" => "team@codewithus.com",
                        "to" => $phoneNumber, 
                        "text" => $textContent);
        
            $json_data = json_encode($data);   
        
            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, "https://api.toky.co/v1/sms/send");
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch,CURLOPT_POSTFIELDS, $json_data);
            
            $curl_response = curl_exec($ch); // Send request
        
            curl_close($ch); // close cURL resource 
            // //End of SMS sending function
        }
        
        return redirect('/admin/updates');
    }

    public function updates(){
        $userId = auth()->user()->id;
        $updates = Update::where('user_id', $userId)->orderBy('created_at','desc')->get();
        return view("admin.updates",compact('updates'));
    }
    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public function calendarView(){
        return view('admin.calendar');
    }

    public function dailyTaskClasses()
    {
        return view('admin.daily_task_classes');
    }

    public function getDailyTaskClasses(Request $request)
    {
        $date = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::now()->today();
        $location_id = $request->input('location_id') ? $request->input('location_id') : '';

        $task_classes = TaskClass::with(['teacher', 'students'])
            ->where('is_deleted', 0)
            ->searchDate('starts_at', $date)
            ->search('location_id', $location_id)
            ->with('task_class_type')
            ->orderBy('starts_at', 'asc')
            ->get();

        if(!$task_classes->count())
        {
            return response()->json(['data'=> null, 'message' => 'No classes scheduled', 'status'=>'error'],404);
        }

        $data = array();
        foreach($task_classes as $index => $task_class)
        {
            $data['teachers'][$index] = $task_class->teacher->count() ? $task_class->teacher->first()->user_name : 'Un-Assigned';

            $data['slots'][$index] = date('g:i A', strtotime($task_class->starts_at));
        }

        $data['teachers'] = array_unique($data['teachers']);
        $data['slots'] = array_unique($data['slots']);

        foreach($data['slots'] as $parent => $slot)
        {
            foreach($task_classes as $index => $task_class)
            {
                if($slot == date('g:i A', strtotime($task_class->starts_at))){
                    $data['students'][$slot][$task_class->teacher->count() ? $task_class->teacher->first()->user_name : 'Un-Assigned'] = $task_class;
                }
            }
        }

        return response()->json(['data'=> $data, 'message' => null, 'status'=>'success'],200);
    }

    public function completedClassesTeacher($id)
    {
        return view('admin.completed-classes-teacher')->withId($id);
    }

    public function getCompletedClassesTeacher(Request $request)
    {
        $completedClasses = User::find($request->input('teacher_id'))->completed_taskclasses()->get();
        $absentClasses = User::find($request->input('teacher_id'))->absent_taskclasses()->get();

        $data = array();

        $data = array();
        foreach($completedClasses as $completedClass) {
            $data['classes'][] = $completedClass;
        }

        $data['completed_taskclasses_count'] = User::find($request->input('teacher_id'))->completed_taskclasses()->count();

        foreach($absentClasses as $absentClass) {
            $data['classes'][] = $absentClass;
        }
        $data['absent_taskclasses_count'] = User::find($request->input('teacher_id'))->absent_taskclasses()->count();

        return response()->json(['completedClasses'=> $data, 'message' => null, 'status'=>'success'],200);
    }
    
}

