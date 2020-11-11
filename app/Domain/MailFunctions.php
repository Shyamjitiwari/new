<?php

namespace App\Domain;

use App\Mail\ClassReminder;
use App\Mail\MailUser;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Mail\SurveyLowRateMail;
use App\Mail\TeachersPayReport;
use App\Mail\InCompleteClassesReminder;
use App\Mail\StudentScheduleRequest;
use App\Mail\ReferenceEmail;

class MailFunctions{
    public function send_free_session_successful_registration_email($to, $message)
	{
        $subject = "Free Session";
        Mail::to($to)->send(new SendMail($subject,$message));
        return back()->with('success','Email has been sent');
    }
    public function send_class_reminder($to, $subject, $message){
        $subject = "Class Reminder for ".$subject;
        Mail::to($to)->send(new ClassReminder($subject,$message));
        return back()->with('success','Email has been sent');
    }
    public function send_holiday_reminder($to, $subject, $message){
        $subject = "Holiday Reminder for ".$subject;
        Mail::to($to)->send(new ClassReminder($subject,$message));
        return back()->with('success','Email has been sent');
    }
    public function send_low_rate_survey_information($to,$message){
        $subject = "Customer sends a low rate";
        Mail::to($to)->send(new SurveyLowRateMail($subject,$message));
        return back()->with('success','Email has been sent');
    }
    public function send_teachers_pay_report($to,$message){
        $subject = "Teachers Pay Report";
        Mail::to($to)->send(new TeachersPayReport($subject,$message));
        return back()->with('success','Email has been sent');
    }
    public function send_teachers_reminder_of_incomplete_marked_classes($to,$message){
        Mail::to($to)->send(new InCompleteClassesReminder($message));
        return back()->with('success','Email has been sent');
    }
    public function send_student_schedule_request_by_parents($to,$message){
        $subject = "Student Schedule Request";
        Mail::to($to)->send(new StudentScheduleRequest($subject,$message));
        return back()->with('success','Email has been sent');
    }
    public static function send_reference_email($to,$message){
        $subject = __('sms_and_email.subject_of_reference_email');
        Mail::to($to)->send(new ReferenceEmail($subject,$message));
        return back()->with('success','Email has been sent');
    }
}
