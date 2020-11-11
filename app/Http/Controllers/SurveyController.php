<?php

namespace App\Http\Controllers;

use App\Domain\MailFunctions;
use Illuminate\Http\Request;
use App\User;
use App\Survey;
use App\Role;
use App\Update;

class SurveyController extends Controller
{
    public function getParentsExperienceSurvey($parentId = null, $teacherId = null, $studentId = null ){

        $studentRoleId = Role::where('role','student')->value('id');
        $parent = User::find($parentId)->first();
        $student = User::find($studentId)->first();
        $teacher = User::find($teacherId)->first();

        $parentEmailId = $parent->email;
        if($parentEmailId == null || $parentEmailId == ""){
            $parentEmailId = $student->email;
            if($parentEmailId == null || $parentEmailId == ""){
                $students = User::where(['phone_number' => $parent->phone_number,
                                         'role_id' => $studentRoleId])->get();
                foreach($students as $student){
                    if($student->email != null && $student->email != ""){
                        $parentEmailId = $student->email;
                    }
                }
            }
        }
        $latestUpdate = Update::where(['teacher_id'=> $teacherId,
                                       'user_id' => $studentId])->latest('id')->first();
        $latestUpdate = $latestUpdate->content;
        return view('survey.parents_survey')->withParent($parentId)
                                            ->withEmail($parentEmailId)
                                            ->withTeaher($teacher->full_name)
                                            ->withUpdate($latestUpdate);
    }

    public function storeParentsExperienceSurvey(Request $request, MailFunctions $mail){
        $survey = new Survey();
        $survey->user_id = $request->parent_id;
        $survey->rate = $request->rate;
        $survey->improvement = $request->improvements_for_cwu;
        $survey->valuable_part_of_cwu = $request->valuable_part_of_cwu;
        $survey->save();

        if($request->rate < 3 && $request->parent_id != null && $request->parent_id != ""){
            $user_information = User::where('id',$request->parent_id)->first();
            $data = array(
                'user_survey_rate' => $request->rate,
                'user_phone_number' => $user_information->phone_number,
                'user_email_id' => $request->parent_email,
                'teacher_name' => $request->teacher_name,
                'latest_update' => $request->latest_update,
            );
            $mail->send_low_rate_survey_information("operations@codewithus.com", $data);
            $mail->send_low_rate_survey_information("rida@codewithus.com", $data);
        }
        return view('survey.thankyou_form');
    }
    public function getAllSurveys(){
        $all_surveys = Survey::orderBy('created_at','desc')->get();
        $surveys = array();
        $role_id = Role::where('role', 'student')->value('id');
        foreach($all_surveys as $survey){
            $phoneNumber = User::where('id', $survey->user_id)->value('phone_number');
            $students = User::where(['phone_number' => $phoneNumber,
                                     'role_id' => $role_id])->get(); 
            $data_array = [
                'serial_no' => $survey->id,
                'user_phone_number' => $phoneNumber,
                'students' => $students,
                'rate' => $survey->rate,
                'improvement' => $survey->improvement,
                'valueable_part_of_cwu' => $survey->valuable_part_of_cwu,
                'date' => $survey->created_at,
            ];
            array_push($surveys, $data_array);
        }
        return view('admin.surveys', compact('surveys'));
    }
}
