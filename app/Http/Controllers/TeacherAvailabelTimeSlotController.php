<?php

namespace App\Http\Controllers;

use App\Day;
use App\Location;
use App\Teacher;
use App\TeacherAvailableTimeSlot;
use App\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherAvailabelTimeSlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|teacher');
    }

    public function getAvailableTimeSlots(Request $request)
    {
        $teacher_id = (int) $request->input('teacher_id');

        $time_slots = TeacherAvailableTimeSlot::where('location_id', $request->input('location_id'))
            ->with(['day', 'time', 'location'])
            ->where('teacher_id', $teacher_id)
            ->where('is_deleted', false)
            ->orderBy('day_id', 'asc')
            ->orderBy('time_id', 'asc')
            ->get();

        $free_time = [];
        $today = Carbon::now();

        foreach($time_slots as $index => $time_slot)
        {
            $date = Carbon::parse($time_slot->day->name .' '.$time_slot->time->time);
            if($date->greaterThan($today)){
                $free_time[$index] = $time_slot;
                $free_time[$index]['time_string'] = $date->toDayDateTimeString();
            }
        }

        return response()->json(['availableTimeSlots'=> $free_time],200);
    }

    public function storeTeacherTimeSlot(Request $request)
    {
        $teacher_id = (int) $request->input('teacher_id');
        $duplicate = TeacherAvailableTimeSlot::where(
            [
                'teacher_id' => $teacher_id,
                'day_id' => $request->input('day_id'),
                'time_id' => $request->input('time_id'),
                'location_id' => $request->input('location_id'),
            ]
        )->get();

        if($duplicate->count()) {
            return response()->json(['data'=> null, 'error' => 'Time slot already added!', 'message' => '', 'status'=>'error'],404);
        }

        $timeSlot = TeacherAvailableTimeSlot::Create(
            [
                'teacher_id' => $teacher_id,
                'day_id' => $request->input('day_id'),
                'time_id' => $request->input('time_id'),
                'location_id' => $request->input('location_id'),
                'limit' => $request->input('limit')
            ]);

        return response()->json(['data'=> $timeSlot, 'message' => 'Time slot added!', 'status'=>'success'],200);
    }

    public function deleteTeacherTimeSlot(TeacherAvailableTimeSlot $timeSlot)
    {
        $timeSlot->delete();

        return response()->json(['data'=> null, 'message' => 'Time slot deleted!', 'status'=>'success'],200);
    }

}
