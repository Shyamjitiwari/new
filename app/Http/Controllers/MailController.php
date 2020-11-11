<?php

namespace App\Http\Controllers;

use App\Country;
use App\Mail\SendCustomRequestMail;
use App\Mail\SendPartnerMail;
use App\Mail\SendRescheduleRequest;
use App\TaskClass;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendPartnerMail(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'number' => 'required',
            'description' => 'required',
        ]);

        Mail::to('partners@codewithus.com')->cc('info@codewithus.com')->bcc('ahmad@codewithus.com')->send(new SendPartnerMail($request));

        return response()->json(['data'=> null, 'message' => null, 'status'=>'success'],200);
    }

    public function sendCustomRequestMail(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'number' => 'required',
            'description' => 'required',
        ]);

        Mail::to('brayan@codewithus.com')->cc(['avesta@codewithus.com', 'info@codewithus.com'])->bcc('ahmad@codewithus.com')->send(new SendCustomRequestMail($request));

        return response()->json(['data'=> null, 'message' => null, 'status'=>'success'],200);
    }

    public function reschedule($student, $reschedule, $taskclass)
    {
        $teacher = TaskClass::find($taskclass->id)->teacher;
        $parent = User::where('phone_number', $student['phone_number'])
            ->where('role_id', 3)
            ->first();

        $calling_code = Country::find($parent->country_id)->calling_code;

        $data = [
            'student_name' => $student['full_name'],
            'parent_number' => $calling_code.$parent->phone_number,
            'parent_email' => $parent->email ? $parent->email : 'N/A',
            'old_date' => $taskclass->starts_at,
            'new_date' => Carbon::parse($reschedule['date'])->toDayDateTimeString(),
            'description' => $reschedule['description'],
            'teacher_name' => $teacher->count() ? $teacher[0]->full_name : 'Un-Assigned',
        ];

        //marking students as absent
        //$taskclass->students()->updateExistingPivot($student['id'],['absent' => true]);

        Mail::to('operations@codewithus.com')->bcc('ahmad@codewithus.com')->send(new SendRescheduleRequest($data));

        return response()->json(['data'=> null, 'message' => null, 'status'=>'success'],200);
    }
}
