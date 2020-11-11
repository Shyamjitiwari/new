<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\LanguageLine;
use App\Lead;
use Illuminate\Http\Request;
use App\Location;
use App\Topic;
use App\FreeSessionTimeSlot;
use App\Day;
use App\Time;
use App\Role;
use App\User;
use App\FreeSessionBooking;
use App\Domain\TokyFunctions;
use App\Domain\MailFunctions;
use Carbon\Carbon;
use App\TaskClass;
use App\Mail\AvailableClassesCount;
use Illuminate\Support\Facades\Mail;
use App\Country;
use DateTimeZone;
use App\Timezone;
use Illuminate\Support\Facades\Storage;
use App\Reference;
use DateTime;

class FreeSessionController extends Controller
{
    protected $private_firsts_session = 'Private First Session';
    protected $free_session = 'Free Session';

    public function formOptions(){
        return view('free_session.free_session_form_options');
    }
    public function signUpForm(){  
         
        $allWebsiteStrings = LanguageLine::all();
        $groups = array();
        foreach($allWebsiteStrings as $websiteString){
            array_push($groups, $websiteString->group);
        }
        $groups = array_unique($groups);

        $localizedStrings = array();
        foreach($groups as $group){
            $data = array();
            $stringsOfTheGroup = LanguageLine::where('group',$group)->get();
            foreach($stringsOfTheGroup as $stringOfTheGroup){
                $textLocales = $stringOfTheGroup->text;
                foreach($textLocales as $key => $value){
                    if($key == "en"){
                        $data[$stringOfTheGroup->key] =  stripslashes($value);
                    }  
                }
            }

            $localizedStrings[$group] = $data;
        }

        return view('free_session.signup_form',compact('localizedStrings'));
    }
    public function signInForm(){
        return view('free_session.signin_form');
    }
    public function getCountryCallingCodes(){
        $countries = Country::all();
        $selectedCountry = Country::first()->value('id');
        return response()->json(['countryCallingCodes' => $countries,'selectedCountry' => $selectedCountry ],200);
    }
    public function findStudentRecordForFreeSession(Request $request){
        $freeSessionUserData = FreeSessionBooking::where(['student_name' => $request->student_name])->get();
        if(count($freeSessionUserData) >= 1){
            return response()->json(['response_msg'=>'Record found'],200); 
        }
        else{
            return response()->json(['response_msg'=>'Record not found'],200); 
        }
    }
    public function allLocationsForFreeSession(){
        $locations = Location::where(['is_deleted' => false,
                                      'show_free_session' => true])->get();
        return response()->json(['locations'=> $locations],200);
    }
    public function allTopics(){
        $topics = Topic::where(['is_deleted' => false, 'free_session' => 1])->get();
       
        return response()->json(['topics'=> $topics],200);
    }
    public function getAvailableTimeSlotsForALocation(Request $request)
    {
        date_default_timezone_set("America/Los_Angeles");
        $duplicateUser = User::where('user_name', $request->input('student_name'))
            ->where('phone_number', $request->input('phone_number'))
            ->first();

        $student_name = $request->input('student_name');

        if($duplicateUser) {
            $this->validate($request, [
                'student_name' => 'required|unique:users,user_name',
            ]);
        } else {
            $student_name = Helper::generateUniqueFieldValue(
                'users',
                'user_name',
                $request->input('student_name'),
                2
            );
        }

        if($request->class_type == 'group') {
            $timeSlots = FreeSessionTimeSlot::where(
                ['location_id' => $request->location_id,
                'is_private' => false,
                'is_deleted' => false,
                ])->orderBy('day_id', 'asc')
                ->orderBy('time_id', 'asc')
                ->get();
        } else if($request->class_type == 'private'){
            $timeSlots = FreeSessionTimeSlot::where(
                ['location_id' => $request->location_id,
                    'is_private' => true,
                    'is_deleted' => false,
                ])->orderBy('day_id', 'asc')
                ->orderBy('time_id', 'asc')
                ->get();
        }

        Storage::append('timeSlots.json', $timeSlots);
        
        $thisMondayAvailableTimeSlots = array();
        $thisTuesdayAvailableTimeSlots = array();
        $thisWednesdayAvailableTimeSlots = array();
        $thisThursdayAvailableTimeSlots = array();
        $thisFridayAvailableTimeSlots = array();
        $thisSaturdayAvailableTimeSlots = array();
        $thisSundayAvailableTimeSlots = array();

        $nextMondayAvailableTimeSlots = array();
        $nextTuesdayAvailableTimeSlots = array();
        $nextWednesdayAvailableTimeSlots = array();
        $nextThursdayAvailableTimeSlots = array();
        $nextFridayAvailableTimeSlots = array();
        $nextSaturdayAvailableTimeSlots = array();
        $nextSundayAvailableTimeSlots = array();

        $mondayAvailabilityTitle = "";
        $tuesdayAvailabilityTitle = "";
        $wednesdayAvailabilityTitle = "";
        $thursdayAvailabilityTitle = "";
        $fridayAvailabilityTitle = "";
        $saturdayAvailabilityTitle = "";
        $sundayAvailabilityTitle = "";

        $thisMondayWeekDate = "";
        $thisTuesdayWeekDate = "";
        $thisWednesdayWeekDate = "";
        $thisThursdayWeekDate = "";
        $thisFridayWeekDate = "";
        $thisSaturdayWeekDate = "";
        $thisSundayWeekDate = "";

        $nextMondayWeekDate = "";
        $nextTuesdayWeekDate = "";
        $nextWednesdayWeekDate = "";
        $nextThursdayWeekDate = "";
        $nextFridayWeekDate = "";
        $nextSaturdayWeekDate = "";
        $nextSundayWeekDate = "";

        $todaysWeekDay = $this->getTodaysWeekDay($request->time_zone);
        $tomorrowsWeekDay = $this->getTomorrowsWeekDay($request->time_zone);
        $dayAfterTomorrowsWeekDay = $this->getDayAfterTomorrowsWeekDay($request->time_zone);

        $student_count = 0;

        foreach($timeSlots as $timeSlot){
            $day = Day::where('id', $timeSlot->day_id)->value('name');
            $time = Carbon::parse(Time::where('id', $timeSlot->time_id)->value('time'))->format('h:i:s A');
            $fotmattedTime = Carbon::parse(Time::where('id', $timeSlot->time_id)->value('time'))->format('h:i A');
            $dateOfTheDay = "next ".$day;
            $date = date('Y-m-d', strtotime($dateOfTheDay));
            $date = Carbon::createFromFormat('Y-m-d', $date);
            $daysToAdd = 7;
            $date = $date->addDays($daysToAdd);
            $date = date('Y-m-d', strtotime($date));

            $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
            $combinedDT = Carbon::createFromFormat('Y-m-d H:i:s',  $combinedDT);

            if($request->class_type == 'group'){
                $task_class = TaskClass::where('name', $this->free_session)
                    ->where('starts_at', Carbon::parse($combinedDT))
                    ->where('is_free_session', 1)
                    ->where('location_id', $request->location_id)
                    ->where('is_deleted', 0)
                    ->withCount('students')
                    ->first();

                if($task_class) {
                    $student_count = $task_class->students_count;
                    if($task_class->students_count >= $task_class->student_limit)
                    {
                        continue;
                    }
                } else {
                    $student_count = 0;
                }
            } else if($request->class_type == 'private'){
                $student_count = TaskClass::where('name', $this->private_firsts_session)
                    ->where('starts_at', Carbon::parse($combinedDT))
                    ->where('is_free_session', 1)
                    ->where('location_id', $request->location_id)
                    ->where('is_deleted', 0)
                    ->count();

                if($student_count >= $timeSlot->limit){
                    continue;
                }
            }

            $combinedDT->setTimezone(new DateTimeZone($request->time_zone));

            $date = date('Y-m-d', strtotime($combinedDT));
            $date = date('M d, l', strtotime($date));

            $dateTitle = date('M d', strtotime($date));
            $dateLabel = date('F d Y', strtotime($date));

            $day = date('l', strtotime($date));
            $time = date('h:i A', strtotime($combinedDT));
            $fotmattedTime =  $time ;
            $dataArray = ["timeslot_id" => $timeSlot->id,
                          "timeslot_time" => $time,
                          "timeslot_formatted" => $fotmattedTime,
                          "timeslot_datetime" => $date." at ".$time,
                "student_count" => $student_count
            ];
            switch ($day) {
                case 'Monday':
                    if($tomorrowsWeekDay != "Monday" && $dayAfterTomorrowsWeekDay != "Monday"){
                        $mondayAvailabilityTitle = $dateTitle;
                        $nextMondayWeekDate = $dateLabel;
                        array_push($nextMondayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 14;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                     "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $mondayAvailabilityTitle = $dateTitle;
                        $nextMondayWeekDate = $dateLabel;
                        array_push($nextMondayAvailableTimeSlots,$dataArray);
                    }
                    break;
                case 'Tuesday':
                    if($tomorrowsWeekDay != "Tuesday" && $dayAfterTomorrowsWeekDay != "Tuesday"){
                        $tuesdayAvailabilityTitle = $dateTitle;
                        $nextTuesdayWeekDate = $dateLabel;
                        array_push($nextTuesdayAvailableTimeSlots,$dataArray);  
                    }
                    else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 14;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                     "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $tuesdayAvailabilityTitle = $dateTitle;
                        $nextTuesdayWeekDate = $dateLabel;
                        array_push($nextTuesdayAvailableTimeSlots,$dataArray);  
                    }
                    break; 
                case 'Wednesday':
                    if($tomorrowsWeekDay != "Wednesday" && $dayAfterTomorrowsWeekDay != "Wednesday"){
                        $wednesdayAvailabilityTitle = $dateTitle;
                        $nextWednesdayWeekDate = $dateLabel;
                        array_push($nextWednesdayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 14;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                     "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $wednesdayAvailabilityTitle = $dateTitle;
                        $nextWednesdayWeekDate = $dateLabel;
                        array_push($nextWednesdayAvailableTimeSlots,$dataArray);
                    }
                    break; 
                case 'Thursday':
                    if($tomorrowsWeekDay != "Thursday" && $dayAfterTomorrowsWeekDay != "Thursday"){
                        $thursdayAvailabilityTitle = $dateTitle;
                        $nextThursdayWeekDate = $dateLabel;
                        array_push($nextThursdayAvailableTimeSlots,$dataArray);
                    } else {
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 14;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $thursdayAvailabilityTitle = $dateTitle;
                        $nextThursdayWeekDate = $dateLabel;
                        array_push($nextThursdayAvailableTimeSlots,$dataArray);
                    }
                    break;
                case 'Friday':
                    if($tomorrowsWeekDay != "Friday" && $dayAfterTomorrowsWeekDay != "Friday"){
                        $fridayAvailabilityTitle = $dateTitle;
                        $nextFridayWeekDate = $dateLabel;
                        array_push($nextFridayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 14;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $fridayAvailabilityTitle = $dateTitle;
                        $nextFridayWeekDate = $dateLabel;
                        array_push($nextFridayAvailableTimeSlots,$dataArray);
                    }
                    break;
                case 'Saturday':
                    if($tomorrowsWeekDay != "Saturday" && $dayAfterTomorrowsWeekDay != "Saturday"){
                        $saturdayAvailabilityTitle = $dateTitle;
                        $nextSaturdayWeekDate = $dateLabel;
                        array_push($nextSaturdayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 14;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $saturdayAvailabilityTitle = $dateTitle;
                        $nextSaturdayWeekDate = $dateLabel;
                        array_push($nextSaturdayAvailableTimeSlots,$dataArray);
                    }
                    break; 
                case 'Sunday':
                    if($tomorrowsWeekDay != "Sunday" && $dayAfterTomorrowsWeekDay != "Sunday"){
                        $sundayAvailabilityTitle = $dateTitle;
                        $nextSundayWeekDate = $dateLabel;
                        array_push($nextSundayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 14;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $sundayAvailabilityTitle = $dateTitle;
                        $nextSundayWeekDate = $dateLabel;
                        array_push($nextSundayAvailableTimeSlots,$dataArray);
                    }
                    break;
            }
        }

        foreach($timeSlots as $timeSlot){
            $day = Day::where('id', $timeSlot->day_id)->value('name');
            $time = Carbon::parse(Time::where('id', $timeSlot->time_id)->value('time'))->format('h:i:s A');
            $fotmattedTime = Carbon::parse(Time::where('id', $timeSlot->time_id)->value('time'))->format('h:i A');
            $dateOfTheDay = "next ".$day;
            //$date = date('M d, l', strtotime($dateOfTheDay));
            $date = date('Y-m-d', strtotime($dateOfTheDay));

            $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
            $combinedDT = Carbon::createFromFormat('Y-m-d H:i:s',  $combinedDT);

            if($request->class_type == 'group'){
                $task_class = TaskClass::where('name', $this->free_session)
                    ->where('starts_at', Carbon::parse($combinedDT))
                    ->where('is_free_session', 1)
                    ->where('location_id', $request->location_id)
                    ->where('is_deleted', 0)
                    ->withCount('students')
                    ->first();

                if($task_class) {
                    $student_count = $task_class->students_count;
                    if($task_class->students_count >= $task_class->student_limit)
                    {
                        continue;
                    }
                } else {
                    $student_count = 0;
                }



            } else if($request->class_type == 'private'){
                $student_count = TaskClass::where('name', $this->private_firsts_session)
                    ->where('starts_at', Carbon::parse($combinedDT))
                    ->where('is_free_session', 1)
                    ->where('location_id', $request->location_id)
                    ->where('is_deleted', 0)
                    ->count();

                if($student_count >= $timeSlot->limit){
                    continue;
                }
            }

            $combinedDT->setTimezone(new DateTimeZone($request->time_zone));

            $date = date('Y-m-d', strtotime($combinedDT));
            $date = date('M d, l', strtotime($date));

            $dateTitle = date('M d', strtotime($date));
            $dateLabel = date('F d Y', strtotime($date));

            $day = date('l', strtotime($combinedDT));
            $time = date('h:i A', strtotime($combinedDT));
            $fotmattedTime =  $time ;
            // $dateTitle = date('M d', strtotime($dateOfTheDay));
            // $dateLabel = date('F d Y', strtotime($dateOfTheDay));
            $dataArray = ["timeslot_id" => $timeSlot->id,
                          "timeslot_time" => $time,
                          "timeslot_formatted" => $fotmattedTime,
                          "timeslot_datetime" => $date." at ".$time,
                             "student_count" => $student_count
            ];
            switch ($day) {
                case 'Monday':
                    if($tomorrowsWeekDay != "Monday" && $dayAfterTomorrowsWeekDay != "Monday"){
                        $mondayAvailabilityTitle = $dateTitle;
                        $thisMondayWeekDate = $dateLabel;
                        array_push($thisMondayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 7;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                     "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $mondayAvailabilityTitle = $dateTitle;
                        $thisMondayWeekDate = $dateLabel;
                        array_push($thisMondayAvailableTimeSlots,$dataArray);
                    }
                    break;
                case 'Tuesday':
                    if($tomorrowsWeekDay != "Tuesday" && $dayAfterTomorrowsWeekDay != "Tuesday"){
                        $tuesdayAvailabilityTitle = $dateTitle;
                        $thisTuesdayWeekDate = $dateLabel;
                        array_push($thisTuesdayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 7;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $tuesdayAvailabilityTitle = $dateTitle;
                        $thisTuesdayWeekDate = $dateLabel;
                        array_push($thisTuesdayAvailableTimeSlots,$dataArray);
                    }
                    break; 
                case 'Wednesday':
                    if($tomorrowsWeekDay != "Wednesday" && $dayAfterTomorrowsWeekDay != "Wednesday"){
                        $wednesdayAvailabilityTitle = $dateTitle;
                        $thisWednesdayWeekDate = $dateLabel;
                        array_push($thisWednesdayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 7;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $wednesdayAvailabilityTitle = $dateTitle;
                        $thisWednesdayWeekDate = $dateLabel;
                        array_push($thisWednesdayAvailableTimeSlots,$dataArray);
                    }
                    break; 
                case 'Thursday':
                    if($tomorrowsWeekDay != "Thursday" && $dayAfterTomorrowsWeekDay != "Thursday"){
                        $thursdayAvailabilityTitle = $dateTitle;
                        $thisThursdayWeekDate = $dateLabel;
                        array_push($thisThursdayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 7;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                     "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $thursdayAvailabilityTitle = $dateTitle;
                        $thisThursdayWeekDate = $dateLabel;
                        array_push($thisThursdayAvailableTimeSlots,$dataArray);
                    }
                    break;
                case 'Friday':
                    if($tomorrowsWeekDay != "Friday" && $dayAfterTomorrowsWeekDay != "Friday"){
                        $fridayAvailabilityTitle = $dateTitle;
                        $thisFridayWeekDate = $dateLabel;
                        array_push($thisFridayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 7;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $fridayAvailabilityTitle = $dateTitle;
                        $thisFridayWeekDate = $dateLabel;
                        array_push($thisFridayAvailableTimeSlots,$dataArray);
                    }
                    break;
                case 'Saturday':
                    if($tomorrowsWeekDay != "Saturday" && $dayAfterTomorrowsWeekDay != "Saturday"){
                        $saturdayAvailabilityTitle = $dateTitle;
                        $thisSaturdayWeekDate = $dateLabel;
                        array_push($thisSaturdayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 7;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $saturdayAvailabilityTitle = $dateTitle;
                        $thisSaturdayWeekDate = $dateLabel;
                        array_push($thisSaturdayAvailableTimeSlots,$dataArray);
                    }
                    break; 
                case 'Sunday':
                    if($tomorrowsWeekDay != "Sunday" && $dayAfterTomorrowsWeekDay != "Sunday"){
                        $sundayAvailabilityTitle = $dateTitle;
                        $thisSundayWeekDate = $dateLabel;
                        array_push($thisSundayAvailableTimeSlots,$dataArray);
                    }else{
                        $dateOfTheDay = "next ".$day;
                        $date = date('Y-m-d', strtotime($dateOfTheDay));
                        $date = Carbon::createFromFormat('Y-m-d', $date);
                        $daysToAdd = 7;
                        $date = $date->addDays($daysToAdd);
                        $date = date('Y-m-d', strtotime($date));
                        $date = date('M d, l', strtotime($date));

                        $dateTitle = date('M d', strtotime($date));
                        $dateLabel = date('F d Y', strtotime($date));
                        $dataArray = ["timeslot_id" => $timeSlot->id,
                                    "timeslot_time" => $time,
                                    "timeslot_formatted" => $fotmattedTime,
                                    "timeslot_datetime" => $date." at ".$time,
                            "student_count" => $student_count
                        ];
                        $sundayAvailabilityTitle = $dateTitle;
                        $thisSundayWeekDate = $dateLabel;
                        array_push($thisSundayAvailableTimeSlots,$dataArray);
                    }
                    break;
            }
        }

        //add student during first step of free free session registration
        $this->addFreeSessionStudent($request, $student_name, $request->input('student_name'));

        $classes_count = 0;
        $classes_count  += count($thisMondayAvailableTimeSlots);
        $classes_count  += count($thisTuesdayAvailableTimeSlots);
        $classes_count  += count($thisWednesdayAvailableTimeSlots);
        $classes_count  += count($thisThursdayAvailableTimeSlots);
        $classes_count  += count($thisFridayAvailableTimeSlots);
        $classes_count  += count($thisSaturdayAvailableTimeSlots);
        $classes_count  += count($thisSundayAvailableTimeSlots);

        $classes_count  += count($nextMondayAvailableTimeSlots);
        $classes_count  += count($nextTuesdayAvailableTimeSlots);
        $classes_count  += count($nextWednesdayAvailableTimeSlots);
        $classes_count  += count($nextThursdayAvailableTimeSlots);
        $classes_count  += count($nextFridayAvailableTimeSlots);
        $classes_count  += count($nextSaturdayAvailableTimeSlots);
        $classes_count  += count($nextSundayAvailableTimeSlots);

        if($classes_count<20){
            $subject = "Availale classes count";
            $data = [
                'location_name' => Location::find($request->location_id)->location_name,
            ];
            Mail::to('shyamjitiwari30@gmail.com')->send(new AvailableClassesCount($subject,$data));
        }

        return response()->json([
                                 'time' => $request->time_zone,
                                 'student_name' => $student_name,
                                 'mondayAvailabilityTitle' => $mondayAvailabilityTitle ,
                                 'tuesdayAvailabilityTitle' => $tuesdayAvailabilityTitle ,
                                 'wednesdayAvailabilityTitle' => $wednesdayAvailabilityTitle ,
                                 'thursdayAvailabilityTitle' => $thursdayAvailabilityTitle ,
                                 'fridayAvailabilityTitle' => $fridayAvailabilityTitle ,
                                 'saturdayAvailabilityTitle' => $saturdayAvailabilityTitle ,
                                 'sundayAvailabilityTitle' => $sundayAvailabilityTitle ,

                                 'thisMondayWeekDate' => $thisMondayWeekDate ,
                                 'thisTuesdayWeekDate' => $thisTuesdayWeekDate ,
                                 'thisWednesdayWeekDate' => $thisWednesdayWeekDate ,
                                 'thisThursdayWeekDate' => $thisThursdayWeekDate ,
                                 'thisFridayWeekDate' => $thisFridayWeekDate ,
                                 'thisSaturdayWeekDate' => $thisSaturdayWeekDate ,
                                 'thisSundayWeekDate' => $thisSundayWeekDate ,

                                 'nextMondayWeekDate' => $nextMondayWeekDate ,
                                 'nextTuesdayWeekDate' => $nextTuesdayWeekDate ,
                                 'nextWednesdayWeekDate' => $nextWednesdayWeekDate ,
                                 'nextThursdayWeekDate' => $nextThursdayWeekDate ,
                                 'nextFridayWeekDate' => $nextFridayWeekDate ,
                                 'nextSaturdayWeekDate' => $nextSaturdayWeekDate ,
                                 'nextSundayWeekDate' => $nextSundayWeekDate ,

                                 'thisMondayAvailableTimeSlots'=> $thisMondayAvailableTimeSlots,
                                 'thisTuesdayAvailableTimeSlots'=> $thisTuesdayAvailableTimeSlots,
                                 'thisWednesdayAvailableTimeSlots'=> $thisWednesdayAvailableTimeSlots,
                                 'thisThursdayAvailableTimeSlots'=> $thisThursdayAvailableTimeSlots,
                                 'thisFridayAvailableTimeSlots'=> $thisFridayAvailableTimeSlots,
                                 'thisSaturdayAvailableTimeSlots'=> $thisSaturdayAvailableTimeSlots,
                                 'thisSundayAvailableTimeSlots'=> $thisSundayAvailableTimeSlots,

                                 'nextMondayAvailableTimeSlots'=> $nextMondayAvailableTimeSlots,
                                 'nextTuesdayAvailableTimeSlots'=> $nextTuesdayAvailableTimeSlots,
                                 'nextWednesdayAvailableTimeSlots'=> $nextWednesdayAvailableTimeSlots,
                                 'nextThursdayAvailableTimeSlots'=> $nextThursdayAvailableTimeSlots,
                                 'nextFridayAvailableTimeSlots'=> $nextFridayAvailableTimeSlots,
                                 'nextSaturdayAvailableTimeSlots'=> $nextSaturdayAvailableTimeSlots,
                                 'nextSundayAvailableTimeSlots'=> $nextSundayAvailableTimeSlots,
                                ],200);
    }

     public function addFreeSessionStudent(Request $request, $student_name, $student_full_name)
     {
        $countryCallingCode = Country::where('id', $request->country_id)->value('calling_code');
        $phoneNumber = $countryCallingCode.$request->phone_number;
        $timezone_id = Timezone::where('time_zone',$request->time_zone)->value('id');

        $user = new User();
        $user->user_name = $student_name;
        $user->password = null;
        $user->full_name = $student_full_name;
        $user->email = $request->email;
        $user->phone_number =$request->phone_number;
        $user->country_id = $request->country_id;
        $user->dob = $request->dob;
        $user->role_id = 4;
        $user->is_free_session = true;
        $user->postal_address = $request->address;
        $user->timezone_id = $timezone_id;
        $user->referral = $request->ad_source;
        $user->save();

        //save lead
        $lead = Lead::updateOrcreate(
            ['id' => $request->input('id')],
            [
                'name' => $student_full_name,
                'phone_number' => $phoneNumber,
                'email' => $request->input('email'),
                'lead_source_id' => 1,
                'lead_status_id' => 2,
                'student_id' => $user->id,
                'form_submitted_at' => Carbon::now()
            ]
        );
     }

    public function addFreeSession(Request $request,TokyFunctions $toky,MailFunctions $mail)
    {
        date_default_timezone_set($request->time_zone);
        if($request->has('new_student_name')) {
            $student_name = $request->input('new_student_name');
            $student_full_name = $request->input('student_name');
        } else {
            $student_name = $request->input('student_name');
        }

        $countryCallingCode = Country::where('id', $request->country_id)->value('calling_code');
        $phoneNumber = $request->phone_number;
        $phoneNumberWithCountryCallingCode = $countryCallingCode.$phoneNumber;

        $fullTimeSlot =$request->time_slot;

        $timeslot_array = explode(" ",$fullTimeSlot);

        $date = $timeslot_array[0]." ".$timeslot_array[1]." ".$timeslot_array[2]." ".$timeslot_array[4]." ".$timeslot_array[5];
        $date = Carbon::createFromFormat('M d, l h:i A', $date );
        $date->setTimezone(new DateTimeZone("America/Los_Angeles"));
        $date = date('M d, l H:i:s', strtotime($date));

        $starts_at = Carbon::parse($date)->toDateTimeString();
        $ends_at = Carbon::parse($date)->addHour()->toDateTimeString();

        $timeslot_array = explode(" ",$date);
        $monthPreFix = $timeslot_array[0];
        $dateArray =explode(",",$timeslot_array[1]);
        $dateOfTheMonth = $dateArray[0];
        $dayOfTheWeek = $timeslot_array[2];
        $timeOfTheDay = ($timeslot_array[3]);

        $day_id =Day::where('name', $dayOfTheWeek)->value('id');
        $time_id = Time::where('time', $timeOfTheDay)->value('id'); 

        $timeslot_id = FreeSessionTimeSlot::where([
            'day_id' => $day_id, 'time_id' => $time_id, 'location_id' => $request->location_id
        ])->value('id');

        $timeslot = FreeSessionTimeSlot::find($timeslot_id);

        $roleId = Role::where('role', "student")->value('id');

        $freeSessionBooking = new FreeSessionBooking();
        $freeSessionBooking->location_id = $request->location_id;
        $freeSessionBooking->student_name = $student_name;
        $freeSessionBooking->dob = $request->dob;
        $freeSessionBooking->phone_number = $phoneNumber;
        $freeSessionBooking->email = $request->email;
        $freeSessionBooking->country_id = $request->country_id;
        $freeSessionBooking->topic_id = $request->topic_id;
        $freeSessionBooking->ad_source = $request->ad_source;
        $freeSessionBooking->free_session_time_slot_id = $timeslot_id;
        $freeSessionBooking->expectations = $request->expectations;
        $freeSessionBooking->save();

        $user = User::where(
            [
                'user_name' => $student_name,
                'email' => $request->email,
                'phone_number' => $phoneNumber,
                'dob' => $request->dob,
                'role_id' => $roleId,
                'postal_address' => $request->address,
            ]
        )->first();

        $user->notes = "Expectations : ". $request->expectations;
        $user->save();
        $topic = Topic::find($request->topic_id);
        $topic->users()->attach($user);
        $location = Location::find($request->location_id);
        $location->users()->attach($user);

        // following if condition is used when group free session is also not free
        //if($request->isPaymentSuccess) {
        // following if condition is used when group free session form is free of cost
        if($request->isPaymentSuccess || $request->class_type == 'group') {

            // After the free session is booked successfully
            if($request->reference_id != null && $request->reference_id != "null" && $request->reference_id != ""){
                $reference = Reference::where('reference_hash',$request->reference_id)->first();
                if($reference->signup_for_camp == false && $reference->signup_for_free_session == false){
                    $today = Carbon::today(new DateTimeZone('America/Los_Angeles'))->toDateString();
                    $dateOfToday = new DateTime($today);
                    $dateOfToday = $dateOfToday->format('Y-m-d');
                    $reference->signup_date = $dateOfToday;
                    $reference->signup_for_camp = true;
                    $reference->referred_to = $user->id;
                    $reference->save();
                }
            }

            //search or create a free session task class and add student to it
            $this->addFreeSessionTaskClass($request->input(), $starts_at, $ends_at, $user, $timeslot->limit, $request->expectations);

            // Send SMS
            $smsMessage = __('free_session.free_session_confirmation', ['Name' => $student_full_name, 'timeSlot' => $request->time_slot." ".$request->time_zone, 'Location' => $location->address]);
            $smsMessage = stripslashes($smsMessage);
            $toky->sms_send($phoneNumberWithCountryCallingCode, $smsMessage);

            $topicName = $topic->name;
            $stringKey = "sms_and_email.topic_based_instructions_for_".$topicName."_in_welcome_email";
            $topicBasedInstructions = __($stringKey, ['Topic' => $topicName]);
            // Send Email
            $data = array(
                'student_name' => $student_full_name,
                'free_session_datetime' => $request->time_slot . " ".$request->time_zone,
                'location_name' => $location->address,
                'topic_based_instructions' => $topicBasedInstructions,
            );
            $mail->send_free_session_successful_registration_email($request->email, $data);
        }
        return response()->json(['response_msg'=>'Data Saved', 'user' => $user],200);
    }
    
    public function getTodaysWeekDay($timezone){
        $weekMap = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
        //date_default_timezone_set($timezone);
        $dayOfTheWeek = Carbon::now($timezone)->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        return $weekday;
    }
    public function getTomorrowsWeekDay($timezone){
        $weekMap = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
       // date_default_timezone_set($timezone);
        $dayOfTheWeek = Carbon::now($timezone)->addDays(1)->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        return $weekday;
    }
    public function getDayAfterTomorrowsWeekDay($timezone){
        $weekMap = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
        //date_default_timezone_set($timezone);
        $dayOfTheWeek = Carbon::now($timezone)->addDays(2)->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        return $weekday;
    }
   
    public function addFreeSessionTaskClass($data, $starts_at, $ends_at, $student, $limit, $description = null)
    {

        if($data['class_type'] == 'group')
        {
            $taskClass = TaskClass::where('starts_at', '=', $starts_at)
                ->where('is_free_session', 1)
                ->where('location_id', $data['location_id'])
                ->where('task_class_type_id', 1)
                ->first();
            $taskClass = $taskClass ? $taskClass : null;
        } else {
            //shall always create a new class if it is a private session
            $taskClass = null;
        }

        if(!$taskClass)
        {
            $taskClass =TaskClass::create([
                'name' => $data['class_type'] == 'group' ? $this->free_session : $this->private_firsts_session,
                'location_id' => $data['location_id'],
                'is_free_session' => $data['class_type'] == 'group',
                'starts_at' => $starts_at,
                'ends_at' => $ends_at,
                'student_limit' => $limit,
                'task_class_type_id' => $data['class_type'] == 'group' ? 1 : 2
            ]);
        }

        //update free_session_date in leads table
        $lead = Lead::where('student_id', $student->id)->orderBy('created_at', 'desc')->first();
        $lead->free_session_date = $starts_at;
        $lead->description = $description;
        $lead->save();

        if($data['class_type'] == 'private')
        {
            $taskClass->users()->attach($student, ['private' => true, 'recurring' => false]);
        } else {
            $taskClass->users()->attach($student, ['free' => true, 'recurring' => false]);
        }

        return response()->json(['data' => null, 'message' => 'Student added to free session class!'],200);
    }

    public function convertStringToMonth($str)
    {
            $monthsMap = collect([
                'Jan' => 1, 'Feb'=> 2, 'Mar'=> 3, 'Apr'=> 4, 'May'=> 5, 'Jun'=> 6, 'Jul'=> 7,
                'Aug'=> 8, 'Sep'=> 9, 'Oct'=> 10, 'Nov'=> 11, 'Dec'=> 12
            ]);

            return $monthsMap[$str];
    }
    public function getThankyouMessage(){
        $thankyouMessage = __('free_session.thankyou_message');
        return response()->json(['response_msg'=>$thankyouMessage],200);
    }

    public function freeSessionSuccessfulRegistration(Request $request){
        $studentName = $request->studentName;
        $timeSlot = $request->timeSlot;
        $thankyouMessage = __('free_session.thankyou_message');
        return view('free_session.successful_registration')
                        ->withStudent($studentName)
                        ->withTimeslot($timeSlot)
                        ->withThankyou($thankyouMessage);
    }
}
