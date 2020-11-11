<?php

namespace App\Http\Controllers;

use App\Age;
use App\Camp;
use App\Country;
use App\Helper\Helper;
use App\Location;
use App\Mail\CampRegistrationIntimation;
use App\Mail\CampRegistrationSuccess;
use App\Mail\SendCustomRequestMail;
use App\TaskClass;
use App\Timezone;
use App\Topic;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use DateTimeZone;
use App\Reference;
use DateTime;

class CampController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function getLocationsForCamps()
    {
        $locations = Location::where(['is_deleted' => 0, 'in_camps' => 1])->get();
        return response()->json(['locations'=> $locations],200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('admin.camps.index');
    }

    public function getCamps()
    {
        $camps = Camp::with(['location', 'taskclasses'])
            ->withCount('taskclasses')
            ->where('is_deleted', 0)
            ->orderBy('starts_at', 'asc')
            ->get();

        return response()->json(['data'=> $camps, 'message' => null, 'status'=>'success'],200);
    }

    /**
     * Stores or updates a newly created resource in db.
     *
     * @param Request $request
     * @param StudentAndClassController $controller
     * @return JsonResponse
     */
    public function store(Request $request, StudentAndClassController $controller)
    {
        $camp = Camp::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $request->input('name'),
                'location_id' => $request->input('location_id'),
                'starts_at' => $request->input('starts_at'),
                'ends_at' => $request->input('ends_at'),
                'bg_color' => $request->input('bg_color') ? $request->input('bg_color') : 'blue',
                'camp_limit' => $request->has('camp_limit') ? $request->input('camp_limit') : 0,
                'hd' => $request->input('hd'),
                'fd' =>  $request->input('fd'),
                'fhd' => $request->input('fhd'),
                'ffd' => $request->input('ffd'),
                'hd_p_id' => $request->input('hd_p_id'),
                'fd_p_id' => $request->input('fd_p_id'),
                'fhd_hd_p_id' => $request->input('fhd_hd_p_id'),
                'fhd_fd_p_id' => $request->input('fhd_fd_p_id'),
                'ffd_hd_p_id' => $request->input('ffd_hd_p_id'),
                'ffd_fd_p_id' => $request->input('ffd_fd_p_id')
            ]
        );

        if($request->input('id')) {
            $msg = 'Camp updated!';
        } else {
            // new classes will be created on store request and not edit
            $time = [
                ['start' => '9:00 AM', 'end' => '12:00 PM', 'name' => 'Morning'],
                ['start' => '1:00 PM', 'end' => '4:00 PM', 'name' => 'Afternoon'],
            ];
            // create camp classes

            foreach ($time as $t)
            {
                $data = [];
                $data['ages']= Age::all()->pluck('id')->toArray();
                $data['camp']= $camp;
                $data['startingDatetime']= $request->input('starts_at').' '.$t['start'];
                $data['endingDatetime'] = $request->input('starts_at').' '.$t['end'];
                $data['isFreeSessionClass']= false;
                $data['student_limit']= 10;
                $data['location_id']= $request->input('location_id');
                $data['recurring']= false;
                $data['repeats']= [
                    Carbon::parse($request->input('starts_at'))->addDay(1)->toDateString(),
                    Carbon::parse($request->input('starts_at'))->addDay(2)->toDateString(),
                    Carbon::parse($request->input('starts_at'))->addDay(3)->toDateString(),
                    Carbon::parse($request->input('starts_at'))->addDay(4)->toDateString(),
                ];
                $data['task_class_type_id']= 1;
                $data['taskclass_name']= $t['name'];
                $data['teacher_id']= $request->input('teacher_id');
                $data['topics']= Topic::all()->pluck('id')->toArray();

                $object = (object) $data;

                $controller->createTaskClass($object);
            }

            $msg = 'Camp saved!';
        }

        return response()->json(['data'=> $camp, 'message' => $msg, 'status'=>'success'],200);
    }

    public function getCamp(Request $request)
    {
        $camp = Camp::find($request->id);

        return response()->json(['data'=> $camp, 'message' => null, 'status'=>'success'],200);
    }

    public function deleteCamp(Request $request)
    {
        $camp = Camp::find($request->id);
        $camp->update(['is_deleted' => 1]);

        return response()->json(['data'=> $camp, 'message' => 'Camp deleted!', 'status'=>'success'],200);
    }

    public function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];

        for($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    public function addStudentToCamp(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $amount_received = 0;
        $request->amount_received ? $amount_received = ((int) $request->amount_received)/100 : $amount_received = 0;

        $timezone_id = Timezone::where('time_zone',$request->input('time_zone'))->value('id');
        $duplicateUserName = User::where('user_name', $request->input('name'))->first();

        if($timezone_id == null || $timezone_id == ""){
            $timezone_id = Timezone::where('time_zone',"America/Los_Angeles")->value('id');
        }

        $duplicateUserName = User::where('user_name', $request->input('name'))->first();

        $student_name = $request->input('name');
        $student_full_name = $request->input('name');

        $existingUser = User::where('user_name', $request->input('name'))
            ->where('phone_number', $request->input('phone_number'))
            ->first();

        if($duplicateUserName && $existingUser == null)
        {
            $student_name = Helper::generateUniqueFieldValue('users','user_name',$request->input('name'),2);
        }

        if($existingUser)
        {
            $student_name = $existingUser->user_name;
            $student_full_name = $existingUser->full_name;
        }

        //get camp
        $camp = Camp::find($request->input('camp_id'));

        //get all task classes for camp
        $camp_dates = $this->generateDateRange(Carbon::parse($camp->starts_at), Carbon::parse($camp->ends_at));

        $goal = $request->input('goal') ? $request->input('goal') : null;
        $referral = $request->input('referral') ? $request->input('referral') : null;
        $notes = $request->input('notes') ? $request->input('notes') : null;

        //create or update user
        $user = User::updateOrCreate(
            [
                'full_name' =>  $student_full_name,
                'phone_number' =>  $request->input('phone_number'),
                'timezone_id' => $timezone_id,
            ],
            [
                'user_name' =>  $student_name,
                'password' =>  null,
                'full_name' =>  $student_full_name,
                'email' =>  $request->input('email'),
                'phone_number' =>  $request->input('phone_number'),
                'dob' =>  $request->input('dob'),
                'country_id' =>  $request->input('country_id'),
                'role_id' =>  4,
                'is_free_session' =>  false,
                'goal' =>  $goal,
                'referral' =>  $referral,
                'notes' =>  'Notes: '.$notes,
                'postal_address' => $request->input('address'),
                'timezone_id' => $timezone_id,
            ]
        );

        if($request->input('topic_id'))
        {
            $user->topics()->attach($request->input('topic_id'));
        }

        if($request->input('location_id'))
        {
            $user->locations()->sync($request->input('location_id'));
        }

        $class_time = $request->input('camp_time');
        $friday_time = $request->input('friday_time');

        $time = '';

        if($class_time == 'half1')
        {
            $time = '09:00:00';
        }
        else if($class_time == 'half2')
        {
            $time = '13:00:00';
        }

        if($request->isPaymentSuccess)
        {
            foreach ($camp_dates as $date)
            {
                if (!Carbon::parse($date)->isFriday())
                {
                    if ($class_time !== 'full')
                    {
                        $task_class = TaskClass::where('camp_id', $camp->id)
                            ->where('starts_at', Carbon::parse($date . ' ' . $time))
                            ->first();
                        $task_class->students()->attach($user->id, ['recurring' => 0]);

                    }
                    else
                    {
                        $task_classes = TaskClass::where('camp_id', $camp->id)
                            ->whereDate('starts_at', Carbon::parse($date))
                            ->get();

                        foreach ($task_classes as $task_class)
                        {
                            $task_class->students()->attach($user->id, ['recurring' => 0]);
                        }
                    }
                }
                else if (Carbon::parse($date)->isFriday() && $request->input('friday'))
                {
                    if ($friday_time !== 'full')
                    {
                        $task_class = TaskClass::where('camp_id', $camp->id)
                            ->where('starts_at', Carbon::parse($date . ' ' . $time))
                            ->first();
                        $task_class->students()->attach($user->id, ['recurring' => 0]);

                    }
                    else
                    {
                        $task_classes = TaskClass::where('camp_id', $camp->id)
                            ->whereDate('starts_at', Carbon::parse($date))
                            ->get();

                        foreach ($task_classes as $task_class)
                        {
                            $task_class->students()->attach($user->id, ['recurring' => 0]);
                        }
                    }
                }
            }
            $this->sendSuccessMessage($user, $camp, $amount_received, $request->input('app_locale'), $request->input('topic_id'),$request->reference_id);
        }
        return response()->json(['data'=> $user, 'message' => 'Student added to camp!', 'status'=>'success'],200);
    }

    public function sendSuccessMessage($student, $camp, $amount_received, $app_locale, $topic_id, $reference_id)
    {
        $topicName = Topic::where('id',$topic_id)->value('name');
        $timezone_name = Timezone::where('id',$student->timezone_id)->value('time_zone');
        $firstCampTaskClass = DB::table('camps as c')
            ->leftJoin('task_classes as tc', 'c.id','=','tc.camp_id')
            ->leftJoin('task_class_user as tcu', 'tcu.task_class_id', '=', 'tc.id')
            ->leftJoin('users as u', 'tcu.user_id', '=', 'u.id')
            ->where('c.id', $camp->id)
            ->where('u.id', $student->id)
            ->select('tc.*')
            ->first();

        $allTheCamps = DB::table('camps as c')
            ->leftJoin('task_classes as tc', 'c.id','=','tc.camp_id')
            ->leftJoin('task_class_user as tcu', 'tcu.task_class_id', '=', 'tc.id')
            ->leftJoin('users as u', 'tcu.user_id', '=', 'u.id')
            ->where('c.id', $camp->id)
            ->where('u.id', $student->id)
            ->select(DB::raw('DATE_FORMAT(tc.starts_at, "%r %Y-%m-%d") as starts_at'))
            ->get();

        if($reference_id != null && $reference_id != "null" && $reference_id != ""){
            $reference = Reference::where('reference_hash',$reference_id)->first();
            if($reference->signup_for_camp == false && $reference->signup_for_free_session == false){
                $today = Carbon::today(new DateTimeZone('America/Los_Angeles'))->toDateString();
                $dateOfToday = new DateTime($today);
                $dateOfToday = $dateOfToday->format('Y-m-d');
                $reference->signup_date = $dateOfToday;
                $reference->signup_for_camp = true;
                $reference->referred_to = $student->id;
                $reference->save();
            }
        }
    
        date_default_timezone_set("America/Los_Angeles");
        $starts_at = Carbon::parse($firstCampTaskClass->starts_at)->format('Y-m-d H:i:s');
        $starts_at = date('Y-m-d H:i:s', strtotime("$starts_at"));
        $starts_at = Carbon::createFromFormat('Y-m-d H:i:s',  $starts_at);
        $starts_at->setTimezone(new DateTimeZone($timezone_name));
        $starts_at = Carbon::parse($starts_at)->format('D M d, Y h:i A');

        $countryCallingCode = Country::where('id', $student->country_id)->value('calling_code');
        $phoneNumber = $student->phone_number;
        $phoneNumberWithCountryCallingCode = $countryCallingCode.$phoneNumber;

        $stringKey = "sms_and_email.topic_based_instructions_for_".$topicName."_in_welcome_email";
        $topicBasedInstructions = __($stringKey, ['Topic' => $topicName]);

        // Send SMS
        $data = [
            'name' => $student->full_name,
            'email' => $student->email,
            'amount' => $amount_received,
            'time' => $starts_at." ".$timezone_name,
            'address' => $camp->location->location_name .", ". $camp->location->address,
            'phone' => $phoneNumberWithCountryCallingCode,
            'listOfCamps' => $allTheCamps,
            'topic' => $topicName,
            'topic_based_instructions' => $topicBasedInstructions,
        ];

        $smsMessage = __('sms_and_email.camps_confirmation', ['Name' => $student->full_name, 'timeSlot' => $starts_at." ".$timezone_name, 'Location' => $camp->location->address]);

        $smsMessage = stripslashes($smsMessage);

        Helper::sendSMS($smsMessage,$phoneNumberWithCountryCallingCode);
        //Mail::to($student->email)->send(new CampRegistrationSuccess($data));
        Mail::to($student->email)->bcc('ahmad@codewithus.com')->send(new CampRegistrationSuccess($data));
        Mail::to('info@codewithus.com')->cc('operations@codewithus.com')->bcc('ahmad@codewithus.com')->send(new CampRegistrationIntimation($data));
    }

    public function getCampsSignUpFormData(Request $request)
    {
        $user_timezone = $request->input('time_zone');
        $timezone = Timezone::where('time_zone',$user_timezone)->first();

        $location = $request->input('location');
        $topics = Topic::where('in_camps', 1)
            ->where('is_deleted', 0)
            ->orderBy('sort', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        if($request->input('next')) {
            $nextWeekFirstDay = Carbon::parse($request->input('next'))->nextWeekday()->format('d-m-Y');
            $nextWeekLastDay = Carbon::parse($nextWeekFirstDay)->nextWeekendDay()->format('d-m-Y');

        } else if($request->input('previous')) {
            $nextWeekFirstDay = Carbon::parse($request->input('previous'))->subWeeks(5)->subDays(2)->nextWeekday()->format('d-m-Y');
            $nextWeekLastDay = Carbon::parse($nextWeekFirstDay)->nextWeekendDay()->format('d-m-Y');
        } else {
            $nextWeekFirstDay = Carbon::now()->nextWeekendDay()->nextWeekday()->format('d-m-Y');
            $nextWeekLastDay = Carbon::parse($nextWeekFirstDay)->nextWeekendDay()->format('d-m-Y');
        }

        $weeks = [];
        $camps = [];

        for($i=1;$i<=5;$i++)
        {
            $weeks[] = ['from' => $nextWeekFirstDay, 'to' => $nextWeekLastDay];
            $nextWeekFirstDay = Carbon::parse($nextWeekFirstDay)->addDays(7)->format('d-m-Y');
            $nextWeekLastDay = Carbon::parse($nextWeekLastDay)->addDays(7)->format('d-m-Y');
        }

        //get camps for this topis in this week
        // $camps_for_this_timezone = $timezone->camps()->get();
        // if(count($camps_for_this_timezone) == null){
        //     $timezone = Timezone::where('time_zone',"America/Los_Angeles")->first();
        // }
        foreach($topics as $parent => $topic)
        {
            foreach($weeks as $index => $week)
            {
                $start_date = Carbon::parse($week['from'])->toDateString();
                $end_date = Carbon::parse($week['to'])->toDateString();

                // $campsData  = $timezone->camps()->where('is_deleted',0)
                //                         ->where('location_id', $location['id'])
                //                         ->where('starts_at', '>=' ,$start_date)
                //                         ->where('ends_at','<=' ,$end_date)
                //                         ->withCount('taskclasses')
                //                         ->first();
                $campsData = Camp::where('is_deleted',0)
                                ->where('location_id', $location['id'])
                                ->where('starts_at', '>=' ,$start_date)
                                ->where('ends_at','<=' ,$end_date)
                                ->withCount('taskclasses')
                                ->first();
                if($campsData != null){
                    $camps[] = $campsData;
                }
            }

            foreach($camps as $index => $camp)
            {
                if($camp)
                {
                    $total_students = 0;
                    foreach($camp->taskclasses as $taskclass)
                    {
                        $total_students = $total_students + $taskclass->students->count();
                    }
                    $camps[$index]['total_students'] = $total_students;
                }
            }

            $newWeeks = [];

            // change weeks array start and end dates to formatted string => Month Date, Year
            foreach($weeks as $index => $week)
            {
                $newWeeks[] = ['from' => Carbon::parse($week['from'])->format('M d, Y'), 'to' => Carbon::parse($week['to'])->format('M d, Y')];
            }

            $topics[$parent]['camps'] = $camps;
            $camps = [];
        }

        return response()->json(['data'=> ['topics' => $topics, 'weeks' => $newWeeks], 'message' => null, 'status'=>'success'],200);
    }

}
