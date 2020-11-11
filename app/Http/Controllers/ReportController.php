<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\TaskClass;
use App\Role;
use App\User;
use App\TaskClassType;
use App\Domain\MailFunctions;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Stripe as StripeModel;
use App\Configuration;
use App\UserParent;
use Exception;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    
    public function getLocations(){
        $locationData = Location::where('is_deleted', 'false')->get();
        $locations = array();
        foreach($locationData as $location){
            $dataArray = ["location_id" => $location['id'],
                "location_name" => $location['location_name'],
            ];
            array_push($locations,$dataArray);
        }
        return response()->json(['locations' =>  $locations],200);
    }

    public function generatePayForTeachersForm(){
        return view('report.pay_report_of_teachers');
    }

    public function generatePayReportForTeacher(Request $request, MailFunctions $mail){
        $period_from = $request->period_from;
        $period_to = $request->period_to;
        $location_id = $request->location_id;
        $location = Location::where('id', $location_id)->first();

        $roleId = Role::where('role','teacher')->value('id');
        $users = $location->users()->where('role_id', $roleId)->get();
        $report_data = "";
        foreach($users as $user){
            $report_data_of_a_single_teacher = "";
            //We might try to fetch all the task class types and make a dynamic array.
            $small_group_class = 0;
            $private_class = 0;
            $after_school_program = 0;
            $half_day_camp_afternoon = 0;
            $half_day_camp_morning = 0;
            $full_day_camp = 0;
            $small_group_class_with_all_students_absent = 0;
            $private_class_with_all_students_absent = 0;
            $after_school_program_with_all_students_absent = 0;
            $half_day_camp_afternoon_with_all_students_absent = 0;
            $half_day_camp_morning_with_all_students_absent = 0;
            $full_day_camp_with_all_students_absent = 0;

            $task_classes = $user->taskclasses()->where('starts_at','>=', $period_from)
                                                ->where('starts_at', '<=',$period_to)->get();
            foreach($task_classes as $task_class){
                $allStudentsAbsent = false;
                $task_class_type_id = $task_class->task_class_type_id;
                $task_class_type_name = TaskClassType::where('id', $task_class_type_id)->value('type_name');

                $student_role_id = Role::where('role', 'student')->value('id');
                $totalStudents = $task_class->users()->where('role_id',$student_role_id)->get();
                $presentStudents = $task_class->present_users()->where('role_id',$student_role_id)->get();

                if(count($presentStudents) == 0){
                    $allStudentsAbsent = true;   
                }

                switch($task_class_type_name){
                    case 'Small Group Class':
                        if($allStudentsAbsent){
                            $small_group_class_with_all_students_absent++;
                        }
                        else{
                            $small_group_class++;
                        }
                        break;
                    case 'Private Class':
                        if($allStudentsAbsent){
                            $private_class_with_all_students_absent++;
                        }
                        else{
                            $private_class++;
                        }
                        break;
                    case 'After School Program':
                        if($allStudentsAbsent){
                            $after_school_program_with_all_students_absent++;
                        }
                        else{
                            $after_school_program++;
                        }
                        break;
                    case 'Half-day Camp Afternoon':
                        if($allStudentsAbsent){
                            $half_day_camp_afternoon_with_all_students_absent++;
                        }
                        else{
                            $half_day_camp_afternoon++;
                        }
                        break;
                    case 'Half-day Camp Morning':
                        if($allStudentsAbsent){
                            $half_day_camp_morning_with_all_students_absent++;
                        }
                        else{
                            $half_day_camp_morning++;
                        }
                        break;
                    case 'Full-day Camp':
                        if($allStudentsAbsent){
                            $full_day_camp_with_all_students_absent++;
                        }
                        else{
                            $full_day_camp++;
                        }
                        break;
                }
            }
            $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<br/><br/><br/>Teacher Name: ".$user->full_name.'<br/>'.
                    "Sessions: ".'<br/>'."<ul>";
            if($small_group_class > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Small Group Class: ".$small_group_class."</li>";
            }
            if($small_group_class_with_all_students_absent > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Small Group Class(All Students Absent): ".$small_group_class_with_all_students_absent."</li>";
            }

            if($private_class > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Private Class: ".$private_class."</li>";
            }
            if($private_class_with_all_students_absent > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Private Class(All Students Absent): ".$private_class_with_all_students_absent."</li>";
            }

            if($after_school_program > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>After School Program: ".$after_school_program."</li>";
            }
            if($after_school_program_with_all_students_absent > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>After School Program(All Students Absent): ".$after_school_program_with_all_students_absent."</li>";
            }

            if($half_day_camp_afternoon > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Half-day Camp Afternoon: ".$half_day_camp_afternoon."</li>";
            }
            if($half_day_camp_afternoon_with_all_students_absent > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Half-day Camp Afternoon(All Students Absent): ".$half_day_camp_afternoon_with_all_students_absent."</li>";
            }

            if($half_day_camp_morning > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Half-day Camp Morning: ".$half_day_camp_morning."</li>";
            }
            if($half_day_camp_morning_with_all_students_absent > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Half-day Camp Morning(All Students Absent): ".$half_day_camp_morning_with_all_students_absent."</li>";
            }

            if($full_day_camp > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Full-day Camp: ".$full_day_camp."</li>";
            }
            if($full_day_camp_with_all_students_absent > 0){
                $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."<li>Full-day Camp(All Students Absent): ".$full_day_camp_with_all_students_absent."</li>";
            }

            $formatted_priod_from = date('F d', strtotime($period_from));
            $formatted_priod_to = date('F d', strtotime($period_to));
            $report_data_of_a_single_teacher = $report_data_of_a_single_teacher."</ul>"."Period worked in this report:<br/>".$formatted_priod_from." - ".$formatted_priod_to;
        
            if($request->send_email){
                $data = array(
                    'message' => $report_data_of_a_single_teacher,
                );
                $userEmailId = $user->email;
                $mail->send_teachers_pay_report("brayan@codewithus.com",$data);
            }
            
            $report_data = $report_data.$report_data_of_a_single_teacher;
        }
        $data = array(
            'message' => $report_data,
        );
        $mail->send_teachers_pay_report("brayan@codewithus.com",$data);
        return response()->json(['report_data' => $report_data],200);
    }

    public function generateROIReport(){

        $student_role_id = Role::where('role','student')->value('id');
        $reportData = DB::table('users as u')
                        ->join('location_user as lu','lu.user_id','=','u.id')
                        ->join('locations as l','l.id','=','lu.location_id')
                        ->join('task_class_user as tcu','tcu.user_id','=','u.id')
                        ->join('task_classes as tc','tc.id','=','tcu.task_class_id')
                        ->join('task_class_types as tct','tct.id','=','tc.task_class_type_id')
                        ->where('u.role_id',$student_role_id)
                        ->select('u.full_name as name','u.dob as dob','l.location_name as location_name','u.referral as referral_source',
                                 'u.created_at as signup_date','u.goal as goals','tct.type_name as class_type', 'u.is_free_session as is_free_session',
                                 'u.id as user_id', 
                                 DB::raw(
                                    "SUM(CASE
                                        WHEN tcu.completed = 1
                                        THEN 1 ELSE 0 END) AS 'completed_classes'"
                                 ),
                                 DB::raw(
                                    "SUM(CASE
                                        WHEN tcu.completed = 0
                                        THEN 1 ELSE 0 END) AS 'in_completed_classes'"
                                 )
                            )
                        ->groupBy('u.id')
                        ->get();
        
        // $stripeLiveSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        // \Stripe\Stripe::setApiKey($stripeLiveSecretKey);

        $parentRoleId = Role::where('role','parent')->value('id');
        foreach($reportData as $data){
            $user = User::where('id',$data->user_id)->first();
            $age = Carbon::parse($data->dob)->age;
            $data->age = $age; 
            
            // $userParentId = User::where(['role_id' => $parentRoleId,
            //                              'phone_number' => $user->phone_number])->value('id');
            // $amount = "0";
            // $stripeCustomerId = UserParent::where('user_id',$userParentId)->value('stripe_customer_id');
            // if($stripeCustomerId != null && $stripeCustomerId != ""){
            //     try{ 
            //         $cus = \Stripe\PaymentIntent::all(['limit' => 1,'customer' =>  $stripeCustomerId]);
            //         $amount = $cus->data[0]->amount;
            //     }
            //     catch(Exception $e){
            //         $amount = "0";
            //     }
            // } 
            // $data->last_payment =  "$".($amount / 100);
        } 
        return view('report.roi_report',compact('reportData'));
    }
}
