<?php

namespace App\Http\Controllers;

use App\Country;
use App\Helper\Helper;
use App\Lesson;
use App\LessonCategory;
use App\LessonSubCategory;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Update;
use Illuminate\Support\Facades\Artisan;
use PDO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Torann\LaravelAsana\Facade\Asana;
use App\TaskClass;
use App\Teacher;
use App\User;
use App\Role;
use App\Location;
use App\Topic;
use App\CreditsCalculation;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin');
    }
    
    public function index()
    {
        return view('teacher.index');
    }

    public function newUpdateForm($taskId=null){
        if($taskId != null){
            return view('teacher.update')->withTaskid($taskId);
        }
        else{
            return view('teacher.update')->withTaskid("");
        }
    }
    public function writeAnUpdate(Request $request){
        // When a teacher writes an update, we should get the phone number from the task data
        // Right now, its dummy
        $userId = auth()->user()->id;
        $content = $request->input('content');
        $teacherName = auth()->user()->user_name;
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

            $createdUpdate = Update::create([  
                'phone_number' => $phoneNumber,
                'user_id' => $userId,
                'is_teacherOrAdmin' => true,
                'content' => $content,
            ]);
            $roleId = Role::where('role', 'parent')->value('id');
            $parentId = User::where(['role_id' => $roleId,
                                     'phone_number' => $phoneNumber])->value('id');
            $student_name = explode (" ", $projectName);
            $smsMessage = __('sms_and_email.link_to_survey');
            $textContent = "Teacher ".$teacherName." has written an update for ".$student_name[0]. 
                            ". Click on this link to see it: https://portal.codewithus.com/parent/update/".$phoneNumber."/".$createdUpdate->id.
                            '. ';
           Helper::sendSMS($phoneNumber,$textContent);
        }
        
        return redirect('/teacher/updates');
    }

    public function updates(){
        $userId = auth()->user()->id;
        $updates = Update::where('user_id', $userId)->orderBy('created_at','desc')->get();
        return view("teacher.updates",compact('updates'));
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
        return view('teacher.calendar');
    }
    public function lessonsForTeachers(){
        return view('teacher.lessons-for-teachers');
    }
    public function storeStudentUpdates(Request $request)
    {
        $student = User::find($request->student_id);
        $countryId = $student->country_id;
        $callingCode = Country::where('id',$countryId)->value('calling_code');
        $phoneNumber = $callingCode.$student->phone_number;  

        $u = Update::create([
            'phone_number' => $student->phone_number,
            'user_id' => $student->id,
            'content' => $request->message,
            'is_teacher' => 0,
            'teacher_id' => Auth::user()->id,
        ]);

        $roleId = Role::where('role', 'parent')->value('id');
        $parent = User::where(['role_id' => $roleId, 'phone_number' => $student->phone_number])->first();
        if($parent == null || $parent == ""){
            $parentCreated = User::create([  
                'user_name' => $student->phone_number,
                'password' =>  bcrypt("pass"),
                'phone_number' => $student->phone_number,
                'country_id' => $student->country_id,
                'role_id' => $roleId,
            ]);
            $parentId = $parentCreated->id;
        }
        else{
            $parentId = $parent->id; 
        }
      
        $message = "Teacher ".Helper::truncateName(Auth::user()->user_name)
            ." has written an update for ". Helper::truncateName($student->user_name).":";

        $smsMessage = __('sms_and_email.link_to_survey');
        $text = $message . ' ' . route('teachers-update', [$student->phone_number, $u->id]).
        '. ';
         
        Helper::sendSMS($text, $phoneNumber);
        return response()->json(['data' => null, 'message' => 'Update added!'],200);
    }

    public function markClassAsAbsent(Request $request)
    {
        DB::table('task_class_user')->where(['id' => $request->input('id')])->update(['absent'=>1]);
        return response()->json(['data'=> null, 'message' => 'Task class marked as absent!', 'status'=>'success'],200);
    }

    public function markClassAsPresent(Request $request)
    {
        DB::table('task_class_user')->where(['id' => $request->input('id')])->update(['absent'=>0]);
        return response()->json(['data'=> null, 'message' => 'Task class marked as present!', 'status'=>'success'],200);
    }

    public function markClassAsCompleted(Request $request)
    {
        // $task_class_id = $request->task_class_id;
        // $task_class_type = TaskClass::where('id',$task_class_id)->value('task_class_type_id');
        // $userPhoneNumber = User::where('id', $request->user_id)->value('phone_number');
       
        // $creditsCalculation = CreditsCalculation::where(['phone_number' => $userPhoneNumber,
        //                                                  'task_class_type_id' => $task_class_type])->first();
        // if($creditsCalculation != null && $creditsCalculation != ""){
        //     $previously_used_credits = $creditsCalculation->credits_used;
        //     $new_credits_used = $previously_used_credits + 1.0;

        //     $creditsCalculation->credits_used = $new_credits_used;
        //     $creditsCalculation->save();
        // }
        // else{
        //     $creditsCalculation = new CreditsCalculation();
        //     $creditsCalculation->phone_number = $userPhoneNumber;
        //     $creditsCalculation->credits_used = 1.0;
        //     $creditsCalculation->task_class_type_id = $task_class_type;
        //     $creditsCalculation->save();
        // }
        DB::table('task_class_user')->where(['id' => $request->input('id')])->update(['completed'=>1]);
        return response()->json(['data'=> null, 'message' => 'Task class marked as completed!', 'status'=>'success'],200);
    }

    public function markClassAsInCompleted(Request $request)
    {
        DB::table('task_class_user')->where(['id' => $request->input('id')])->update(['completed'=>0]);
        return response()->json(['data'=> null, 'message' => 'Task class marked as incomplete!', 'status'=>'success'],200);
    }

    public function completedClasses($id)
    {
        $user = Auth::user();
        if($user->role_id == 2){
            return view('teacher.completed-classes')->withId($id);
        } else {
            return view('admin.completed-classes')->withId($id);
        }
    }

    public function getAllUpcomingClasses()
    {
        $upComingClasses = User::find(Auth::user()->id)
            ->taskClassesWithStudents()
            ->whereDate('starts_at', '>=', Carbon::now()->startOfDay())
            ->whereDate('ends_at', '<=', Carbon::now()->addWeeks(2))
            ->orderBy('starts_at')
            ->paginate(10);

        return response()->json(['upComingClasses'=> $upComingClasses],200);
    }

    public function lessonCategories()
    {
        $categories = LessonCategory::where('is_deleted', 0)->get();
        return view('teacher.lessons.categories')->withCategories($categories);
    }

    public function lessonSubCategories($id)
    {
        $sub = LessonSubCategory::where('is_deleted', 0)->where('lesson_category_id', $id)->get();
        return view('teacher.lessons.sub-categories')->withSub($sub);
    }

    public function lessons($id)
    {
        $lessons = Lesson::where('is_deleted', 0)->where('lesson_sub_category_id', $id)->get();
        return view('teacher.lessons.lessons')->withLessons($lessons);
    }

    public function cronRecurringClasses()
    {
        Artisan::call('taskclass:autorecurring');
        return back()->with('success', 'Recurring classes created');
    }

    public function getIncompleteTeachersClasses(Request $request)
    {
        $incompleteTaskClasses = User::find($request->input('teacher_id'))->incomplete_taskclasses()->get();

        $incompleteNotAbsentClasses = [];
        foreach($incompleteTaskClasses as $class)
        {
            if(!$class->pivot->absent) {
                $incompleteNotAbsentClasses[] = $class;
            }
        }

        return response()->json(['incompleteTaskClasses'=> $incompleteNotAbsentClasses],200);
    }

    public function showStudentUpdates(Request $request)
    {
        $student = User::find($request->input('student_id'));

        $updates = $student->user_updates;

        return response()->json(['data'=> $updates, 'message' => null, 'status'=>'success'],200);
    }

    public function showTeacherTimeSlots()
    {
        return view('teacher.time_slots');
    }
}

