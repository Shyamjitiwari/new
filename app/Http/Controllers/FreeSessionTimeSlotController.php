<?php

namespace App\Http\Controllers;

use App\FreeSessionTimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\FreeSessionBooking;
use App\TaskClass;
use App\Location;
use App\Teacher;
use App\Update;
use App\Topic;
use App\Time;
use App\User;
use App\Role;
use App\Day;

class FreeSessionTimeSlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    public function freeSessionTimeSlots(){
        return view('free_session_time_slots.admin_index');
    }
    public function getAllLocationsForFreeSession(){
        $locationsData = Location::where('show_free_session', true)->get();
        $locations = array();
        foreach($locationsData as $location){
            $dataArray = ["location_id" => $location->id,
                          "location_name" => $location->location_name,
            ];
            array_push($locations,$dataArray);
        }
        return response()->json(['locations'=> $locations],200);
    }
    public function getDaysForFreeSession(){
        $daysData = Day::where('is_deleted',false)->get();
        $days = array();
        foreach($daysData  as $day){
            $dataArray = ["day_id" => $day->id,
                          "day_name" => $day->name,
            ];
            array_push($days,$dataArray);
        }
        return response()->json(['days'=> $days],200);
    }
    public function getTimesForFreeSession(){
        $timesData = Time::where('is_deleted',false)->get();
        $times = array();
        foreach($timesData  as $time){
            $dataArray = ["time_id" => $time->id,
                          "time_time" => Carbon::parse($time->time)->format('h:i A'),
            ];
            array_push($times,$dataArray);
        }
        return response()->json(['times'=> $times],200);
    }
    public function getAvailableTimeSlotsForALocation(Request $request){
        $availableTimeSlotsData = FreeSessionTimeSlot::where(['location_id' => $request->location_id, 'is_deleted' => false])
            ->orderBy('day_id', 'asc')
            ->orderBy('time_id', 'asc')
            ->get();
        $locationName = Location::where('id', $request->location_id)->value('location_name');
        $availableTimeSlots = array();
        foreach($availableTimeSlotsData as $availableTimeSlot){
            $day = Day::where('id',$availableTimeSlot->day_id)->value('name');
            $time = Time::where('id',$availableTimeSlot->time_id)->value('time');
            $dataArray = ["timeslot_id" =>  $availableTimeSlot->id,
                          "location_id" => $request->location_id,
                          "location_name" => $locationName,
                          "day_id" => $availableTimeSlot->day_id,
                          "day_name" => $day,
                          "limit" => $availableTimeSlot->limit,
                          "time_id" => $availableTimeSlot->time_id,
                          "time_time" => Carbon::parse($time)->format('h:i A'),
                        "is_private" => $availableTimeSlot->is_private
            ];
            array_push($availableTimeSlots,$dataArray);
        }
        return response()->json(['availableTimeSlots'=> $availableTimeSlots],200);
    }
    public function deleteTimeSlotFromALocation(Request $request){
        $freeSessionTimeSlot = FreeSessionTimeSlot::where('id',$request->timeslot_id)->first();
        $freeSessionTimeSlot->is_deleted = true;
        $freeSessionTimeSlot->save();

        return response()->json(['response_msg'=>'Data Deleted'],200);
    }
    public function addTimeSlotToALocation(Request $request){
        
        $getUnDeletedData = FreeSessionTimeSlot::where(['day_id' => $request->day_id,
                                               'time_id' => $request->time_id,
                                               'location_id' => $request->location_id,
                                               'is_private' => ($request->is_private == 'group') ? false : true,
                                               'is_deleted' => false ])->first();
        $getDeletedData = FreeSessionTimeSlot::where(['day_id' => $request->day_id,
                                               'time_id' => $request->time_id,
                                               'location_id' => $request->location_id,
                                                'is_private' => ($request->is_private == 'group') ? false : true,
                                               'is_deleted' => true ])->first();

        if($getUnDeletedData != null){
            return response()->json(['response_msg'=>'Duplicate Entry'],200);
        }
        elseif($getDeletedData != null){
            $getDeletedData->limit = $request->limit;
            $getDeletedData->is_deleted = false;
            $getDeletedData->save();
        }
        else{
            $freeSessionTimeSlot = new FreeSessionTimeSlot();
            $freeSessionTimeSlot->day_id = $request->day_id;
            $freeSessionTimeSlot->time_id = $request->time_id;
            $freeSessionTimeSlot->limit = $request->limit;
            $freeSessionTimeSlot->location_id = $request->location_id;
            $freeSessionTimeSlot->is_private = ($request->is_private == 'group') ? false : true;
            $freeSessionTimeSlot->save();

            return response()->json(['response_msg'=>'Data Saved'],200);
        }
    }
}
