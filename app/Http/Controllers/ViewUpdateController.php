<?php

namespace App\Http\Controllers;

use App\Mail\BulkMessageCustomSender;
use App\Mail\MailToTeacherOnParentsResponseToUpdate;
use Illuminate\Http\Request;
use App\Update;
use App\User;
use App\Role;
use App\Survey;
use Illuminate\Support\Facades\Mail;

class ViewUpdateController extends Controller
{
    public function viewUpdate($phoneNumber, $updateId){
        $updatesData = Update::where('phone_number',$phoneNumber)->get();
        foreach($updatesData as $update){
            if($update->id == $updateId){

                $userName = User::where('id', $update->user_id)->value('full_name');
                $isTeacher = $update->is_teacherOrAdmin;
                if($isTeacher){
                    $created_by = "Teacher: ".$userName;  
                }
                else{
                    $created_by = "Student: ".$userName;
                }
                $update = ["id" => $update->id,
                            "content" =>  $update->content,
                            "created_at" => $update->created_at,
                            "created_by" => $created_by
                ];
                return view("view_updates.update",compact('update'));
            }
        }
    }
    
    public function viewStudentUpdate($phoneNumber, $updateId)
    {
        $update = Update::where('phone_number',$phoneNumber)
            ->where('id', $updateId)
            ->where('teacher_id', '<>', null)
            ->with('teacher')
            ->first();

        if(!$update) {
            return view("view_updates.blank");
        } else {
            $roleIdForParent = Role::where('role','parent')->value('id');
            $userId = User::where(['phone_number' => $phoneNumber,
                                            'role_id' => $roleIdForParent])->value('id');
            return view("view_updates.teachers-update")->withUpdate($update)->withParentid($userId);
        }
    }
    public function submitUserFeedback(Request $request)
    {
        $update = \App\Update::find($request->input('update_id'));

        $survey = new Survey();
        $survey->user_id = $request->user_id;
        $survey->improvement = $request->feedback;
        $survey->update_id = $update->id;
        $survey->student_id = $update->user_id;
        $survey->save();

        $teacher = User::find($update->teacher_id);
        $student = User::find($update->user_id);

        $m = 'Your update regarding '.$student->full_name.' has been replied to as below:';

        //update teacher via email
        if($teacher->email)
        {
            Mail::to($teacher->email)->send(new MailToTeacherOnParentsResponseToUpdate($teacher->user_name, $m, $request->input('feedback'), $student));
        }

        return view('view_updates.thankyou');
    }
}
