<?php

namespace App\Http\Controllers;

use App\Country;
use App\Helper\Helper;
use App\Mail\SendRescheduleRequest;
use App\Role;
use App\Student;
use App\TaskClass;
use App\TeacherAvailableTimeSlot;
use App\Topic;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ParentStudentController extends Controller
{
    protected $private_firsts_session = 'Private First Session';
    protected $free_session = 'Free Session';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:parent|student');
    }

    public function calendarViewStudent(){
        return view('students.calendar');
    }

    public function calendarViewParent(){
        return view('parents.calendar');
    }

    public function getStudentsForParent()
    {
        $user = Auth::user();
        if($user->role_id == 3)
        {
            $students = User::where('phone_number', $user->phone_number)
                ->where('role_id', 4)
                ->where('is_deleted', 0)
                ->get();
        } else {
            $students[] = $user;
        }

        return response()->json(['students'=> $students, 'message' => null, 'status'=>'success'],200);
    }

    public function getCalendarEvents(Request $request)
    {
        $user = Auth::user();
        $selected_students = array();

        if($user->role_id == 3 && !$request->has('student_id'))
        {
            $selected_students = User::where('phone_number', $user->phone_number)
                ->where('role_id', 4)
                ->where('is_deleted', 0)
                ->get();
        } else if ($user->role_id == 3 && $request->has('student_id')) {
            $selected_students = User::where('id',$request->input('student_id'))->get();
        } else {
            $selected_students = User::where('id', $user->id)->get();
        }

        $taskClasses = TaskClass::where(['is_deleted' => false, 'is_completed' => false,])
                            ->whereHas('students', function($query) use($selected_students) {
                                $query->whereIn('user_id',collect($selected_students)->pluck('id')->toArray());
                            })
                            ->orderBy('starts_at','ASC')
                            ->get();

        $events = array();

        foreach($taskClasses as $taskClass)
        {
            $students = array();
            $teacher = "Un-Assigned";
            $starts_at = $taskClass->starts_at;
            $ends_at = $taskClass->ends_at;
            $isFreeSession = $taskClass->is_free_session;
            $isRecurring = $taskClass->recurring;
            $timestamp_starttime = strtotime($taskClass->starts_at);
            $startTime = date('h:i A', $timestamp_starttime);

            $timestamp_endtime = strtotime($taskClass->ends_at);
            $endTime = date('h:i A', $timestamp_endtime);

            $teacher = "<span style='color: white'>"
                .$startTime."-".$endTime."<br>".$teacher."<br>".$taskClass->name."</span>";
            $pivotTableData = $taskClass->users;

            foreach($pivotTableData as $data){
                $role = Role::where('id',$data->role_id)->value('role');
                if($role == "teacher"){
                    $teacher = "<span style='color: white'>".$startTime."-".$endTime."<br><span style='font-size: large;'>"
                        .$data->full_name."</span><br>".$taskClass->name."</span>";
                }
                else {
                    foreach($selected_students as $st) {
                        if($data->id == $st->id){
                            $dataArray = [
                                "student_id" => $data->id,
                                "student_name" => Helper::isFreeOrFirst($data) . $data->full_name . Helper::getAge($data->dob) . Helper::getTopic($data),
                                'completed' => $data->pivot->completed ? 1 : 0,
                                'absent' => $data->pivot->absent ? 1 : 0,
                                "starts_at" => $starts_at,
                                "ends_at" => $ends_at,
                            ];
                            array_push($students, $dataArray);
                        }
                    }
                }
            }

            if(count($pivotTableData) > 0)
            {
                $title = "<b>".$teacher."</b>";
                $content = '<div style="background-color:#FCF3CF;margin:5px;color:black">';
                foreach($students as $student){
                    if($student['completed'] == 1) {
                        $content = $content . "<a title='Completed' style='background-color:darkgrey; color:black'>" . $student['student_name'] . '</a></div><div style="background-color:#FCF3CF;margin:5px;color:black">';
                    } else if($student['absent'] == 1) {
                        $content = $content . "<a title='Absent' style='background-color:red; color:white'>" . $student['student_name'] . '</a></div><div style="background-color:#FCF3CF;margin:5px;color:black">';
                    } else {
                        $content = $content . "<a title='Click to reschedule class' class='text-capitalize' href='/parent/reschedule/" . $student['student_id']. '/'.$taskClass->id . "'>" . $student['student_name'] . '</a></div><div style="background-color:#FCF3CF;margin:5px;color:black">';
                    }
                    $starts_at = $student['starts_at'];
                    $ends_at = $student['ends_at'];
                }

                if($isFreeSession)
                {
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
            return response()->json(['response_msg'=>'No scheduled classes have been found.'],200);
        }
        else{
            return response()->json(['events'=> $events],200);
        }
    }

    public function reschedule(User $student, TaskClass $taskClass)
    {
        // do not all class to be rescheduled, if the class has been completed
        if(Carbon::parse($taskClass->starts_at)->timestamp < Carbon::now()->timestamp)
        {
            return redirect()->route('parents.calendar')->with('warning', 'Class has been completed, cannot reschedule!');
        }
        // do not all class to be rescheduled, if the start time is within then 48 hours from today
        elseif(Carbon::parse($taskClass->starts_at)->timestamp <= Carbon::now()->addDays(2)->timestamp)
        {
            return redirect()->route('parents.calendar')->with('danger', 'You cannot reschedule a class within 
            48 hours by using the portal. If it is an emergency, please email info@codewithus.com or send an SMS text 
            to 4089097717 and we will do our best to accommodate.');
        }
        elseif($taskClass->is_free_session)
        {
            return redirect()->route('parents.calendar')->with('danger', 'You cannot reschedule a free session class. 
            If it is an emergency, please email info@codewithus.com or send an SMS text 
            to 4089097717 and we will do our best to accommodate.');
        }
        elseif($taskClass->is_camp)
        {
            return redirect()->route('parents.calendar')->with('danger', 'Cannot reschedule a Camp Session');
        }

        $pivot = DB::table('task_class_user')->where('task_class_id', $taskClass->id)->where('user_id', $student->id)->first();

        if($pivot->completed || $pivot->absent)
        {
            $message = '';

            $pivot->absent ? $message = 'Student marked as absent, cannot reschedule class.' : null;
            $pivot->completed ? $message = 'Student marked as completed, cannot reschedule class.' : null;
            return redirect()->route('parents.calendar')->with('danger', $message);
        }

        $tc = TaskClass::with('teacher')->find($taskClass->id);
        $teacher = [];

        if(count($tc->teacher))
        {
            foreach ($tc->teacher as $index => $t) {
                $teacher = $t;
            }
        }
        else
        {
            $teacher = 'Un Assigned';
        }

        $tc['class_teacher'] = $teacher;

        return view('parents.reschedule')->withStudent($student)->withTaskclass($tc);
    }

    public function getAvailableTaskClasses(Request $request, CampController $controller)
    {
        $s = $request->input('student');
        $taskclass = $request->input('taskclass');
        $student = User::with('locations')->find($s['id']);

        $student = User::find($s['id']);
        $topics = $student->topics()->get();

        foreach ($taskclass['teacher'] as $t)
        {
            $teacher = User::find($t['id']);
        }

        if($request->input('topics'))
        {
            $topics = Topic::where('is_deleted', 0)->get();
        }

        $nextWeek = Carbon::parse($taskclass['starts_at'])->addDays(7);
        $lastWeek = Carbon::parse($taskclass['starts_at'])->subDays(7);
        $today = Carbon::parse($taskclass['starts_at']);
        $message = null;

        $pivot = DB::table('task_class_user')->where('task_class_id', $taskclass['id'])->where('user_id', $student['id'])->first();

        if($pivot->private == 1) // is a private class
        {
            // get all available teachers slots
            $availableTeachersSlots = TeacherAvailableTimeSlot::where('location_id', $taskclass['location_id'])
                ->with(['day', 'time', 'location', 'teacher'])
                ->where('is_deleted', false)
                ->orderBy('day_id', 'asc')
                ->orderBy('time_id', 'asc')
                ->get();

            $newTaskClasses = [];

            $dates = $controller->generateDateRange($today, $nextWeek);

            foreach($dates as $parent => $date)
            {
                $availableTeachersSlots = TeacherAvailableTimeSlot::where('location_id', $taskclass['location_id'])
                    ->with(['day', 'time', 'location', 'teacher'])
                    ->whereHas('day', function($query) use($date){
                        $query->where('name', Carbon::parse($date)->format('l'));
                    })
                    ->where('is_deleted', false)
                    ->orderBy('day_id', 'asc')
                    ->orderBy('time_id', 'asc')
                    ->get();

                $availableTeachersSlotsWithNoStudents = [];

                foreach($availableTeachersSlots as $index => $time_slot)
                {
                    $starts_at = Carbon::parse($date.' '.$time_slot->time->time);

                    $isTaskClassPresent = TaskClass::where('starts_at', $starts_at)
                        ->where('location_id', $taskclass['location_id'])
                        ->first();

                    if(!$isTaskClassPresent)
                    {
                        $availableTeachersSlotsWithNoStudents[$index] = $time_slot;
                    }
                }

                foreach($availableTeachersSlotsWithNoStudents as $index => $available_time_slot)
                {
                    $newTaskClasses[$parent.$index]['name'] = 'Private Class';
                    $newTaskClasses[$parent.$index]['new_starts_at'] = (Carbon::parse($date.' '.$available_time_slot->time->time))->toDayDateTimeString();
                    $newTaskClasses[$parent.$index]['new_ends_at'] = (Carbon::parse($date.' '.$available_time_slot->time->time))->addHour()->toDayDateTimeString();
                    $newTaskClasses[$parent.$index]['class_teacher'] = $available_time_slot->teacher;
                }
            }
        } else
        {
            $taskClasses = TaskClass::where('location_id', $taskclass['location_id'])
                ->with('teacher')
                ->withCount('students')
                ->where('camp_id', null)
                ->where('starts_at','>=' ,$lastWeek)
                ->where('ends_at','<=' ,$nextWeek)
                ->orderBy('starts_at', 'asc')
                ->get();

            $newTaskClasses = [];
            $message = null;

            //sending last weeks classes as options available to reschedule but adding 7 days to them
            foreach($taskClasses as $index => $taskClass)
            {
                $newTaskClasses[] = $taskClass;
                $newTaskClasses[$index]['new_starts_at'] = Carbon::parse($taskClass->starts_at)->addDays(7)->toDayDateTimeString();
                $newTaskClasses[$index]['new_ends_at'] = Carbon::parse($taskClass->ends_at)->addDays(7)->toDayDateTimeString();
                count($taskClass['teacher']) > 0 ? $newTaskClasses[$index]['class_teacher'] = $taskClass['teacher'][0] : $newTaskClasses[$index]['class_teacher'] = 'Un assigned';
            }
        }

        return response()->json(['taskClasses'=> $newTaskClasses, 'message' => $message, 'status'=>'success'],200);
    }

    public function rescheduleUpdate(Request $request)
    {
        $reschedule = $request->input('reschedule');
        $student = $request->input('student');
        $selectedTaskClass = $reschedule['selectedTaskClass'];
        $currentClass = $request->input('taskclass');

        $pivot = DB::table('task_class_user')->where('task_class_id', $currentClass['id'])->where('user_id', $student['id'])->first();

        $this->rescheduleClass($student, $selectedTaskClass,$currentClass,$pivot, $reschedule);

        return response()->json(['data'=> null, 'message' => 'Student\'s schedule updated!', 'status'=>'success'],200);
    }

    public function rescheduleClass($student, $selectedTaskClass,$currentClass,$pivot, $reschedule)
    {
        //check if the requested class is available on that day ?
        $isAvailable = TaskClass::where([
            'location_id' => $currentClass['location_id'],
            'camp_id' => null,
            'task_class_type_id' => $currentClass['task_class_type_id'],
            'starts_at' => Carbon::parse($selectedTaskClass['new_starts_at']),
        ])->first();

        // if not then create class
        if(!$isAvailable)
        {
            $newClass = TaskClass::create([
                'name' => $currentClass['name'],
                'location_id' => $currentClass['location_id'],
                'student_limit' => $currentClass['student_limit'],
                'task_class_type_id' => $currentClass['task_class_type_id'],
                'is_free_session' => $currentClass['is_free_session'],
                'recurring' => $currentClass['recurring'],
                'starts_at' => Carbon::parse($selectedTaskClass['new_starts_at']),
                'ends_at' => Carbon::parse($selectedTaskClass['new_ends_at'])
            ]);
            if(is_array($selectedTaskClass['class_teacher'])){
                $newClass->teacher()->attach($selectedTaskClass['class_teacher']['id']);
            }
        } else
        {
            $newClass = $isAvailable;
        }

        // marking students as absent in the existing class
        DB::table('task_class_user')->where('id', $pivot->id)->update(['absent' => true]);

        // assign student to class
        $newClass->students()->attach($student['id'],[
            'free' => $pivot->free,
            'recurring' => $pivot->recurring,
            'first' =>$pivot->first,
            'private'=>$pivot->private
        ]);

        //send mail
        $parent = User::where('phone_number', $student['phone_number'])
            ->where('role_id', 3)
            ->first();

        $calling_code = Country::find($parent->country_id)->calling_code;

        $data = [
            'student_name' => $student['full_name'],
            'parent_number' => $calling_code.$parent->phone_number,
            'parent_email' => $parent->email ? $parent->email : 'N/A',
            'old_date' => $currentClass['starts_at'],
            'new_date' => Carbon::parse($selectedTaskClass['new_starts_at'])->toDayDateTimeString(),
            'description' => $reschedule['description'],
            'teacher_name' => is_array($selectedTaskClass['class_teacher']) ? $selectedTaskClass['class_teacher']['full_name'] : 'Un-Assigned',
        ];

        Mail::to('operations@codewithus.com')->bcc('ahmad@codewithus.com')->send(new SendRescheduleRequest($data));
    }

}
