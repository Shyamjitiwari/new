<?php

namespace App\Http\Controllers;

use App\CreditsCalculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Location;
use App\TaskClassType;
use App\Role;
use App\User;
use App\Credit;
use App\Stripe;
use Carbon\Carbon;
use DateTimeZone;

class CreditsCalculationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin');
    }

    public function creditsCalculationIndex(){
        $user = Auth::user();
        $role = $user->role->role;
        $role = "admin";
        if($role == "admin"){
            $locationData = Location::where('is_deleted', false)->get();
        }
        elseif($role == "teacher"){
           $locationData = $user->locations()->get();
        }
        $locations = array();
        foreach($locationData as $location){
            $dataArray = ["location_id" => $location['id'],
                "location_name" => $location['location_name'],
            ];
            array_push($locations,$dataArray);
        }
        $usersCreditsData = null;
        $usersCredits = null;
        return view('credits_calculation.admin_index', compact('locations','usersCreditsData','usersCredits'));
    }
    public function getLocations()
    {
        $user = Auth::user();
        $role = $user->role->role;
        $role = "admin";
        if($role == "admin"){
            $locationData = Location::where('is_deleted', false)->get();
        }
        elseif($role == "teacher"){
            $locationData = $user->locations()->get();
        }
        $locations = array();
        foreach($locationData as $location){
            $dataArray = ["location_id" => $location['id'],
                "location_name" => $location['location_name'],
            ];
            array_push($locations,$dataArray);
        }
        return response()->json(['locations'=> $locations],200);
    }

    public function getUsersCredits(Request $request){
        $roleId = Role::where('role', 'parent')->value('id');
        $location = Location::where('id',$request->location_id)->first();
        $users = $location->users()->get();

        $creditsCalculationData = array();
        foreach($users as $user){
            $phoneNumber = $user->phone_number;
            
            $parent = User::where(['phone_number' => $phoneNumber, 
                                   'role_id' => $roleId])->first();
            if($parent != null && $parent != ""){
                $usersData = CreditsCalculation::where('phone_number',$phoneNumber)->get();
                foreach($usersData as $userData){
                    $task_class_type = TaskClassType::where('id', $userData->task_class_type_id)->value('type_name');
                    $remaining_credits = $userData->credits_given - $userData->credits_used;
                    $dataArray = [
                                'user_id' => $user->id,
                                'user_name' => $user->full_name,
                                'user_email' => $user->email,
                                'task_class_type' => $task_class_type,
                                'credits_given' => $userData->credits_given,
                                'credits_used' => $userData->credits_used,
                                'remaining_credits' => $remaining_credits,
                    ];
                    array_push($creditsCalculationData,$dataArray);
                }
            }    
        }
        return response()->json(['userCredits'=> $creditsCalculationData],200);
    }

    public function getCreditsInADateRange(Request $request){
        $roleIdForParent = Role::where('role', 'parent')->value('id');
        $roleIdForStudent = Role::where('role', 'student')->value('id');
        $location = Location::where('id',$request->location_id)->first();
        $users = $location->users()->where('role_id',$roleIdForStudent)->get();

        $taskClassTypes = TaskClassType::all();
        $creditsCalculationData = array();
        foreach($users as $user){
            $emailId = User::where(['phone_number' => $user->phone_number,
                                    'role_id' => $roleIdForParent])->value('email');
            if($emailId != null && $emailId != ""){
                foreach($taskClassTypes as $taskClassType){
                    $getCompletedTaskClasses = $user->completed_taskclasses()
                                                    ->where('task_class_type_id',$taskClassType->id)
                                                    ->where('starts_at', '>=', $request->starting_date)
                                                    ->where('starts_at', '<=', $request->ending_date)->get();
            
                    $completedTaskClasses = count($getCompletedTaskClasses);
                    $getPaymentsMade = Credit::where(['customer_email' => $emailId,
                                                      'task_class_type_id' => $taskClassType->id])->get();
                    $totalCreditsGiven = 0.0;
                    foreach($getPaymentsMade as $getPaymentMade){
                        $totalCreditsGiven += $getPaymentMade->credits_given;
                    }

                    $totalCreditsForClassType =  Stripe::where('task_class_type_id',$taskClassType->id)
                                                       ->value('number_of_credits');
                 
                    $totalCreditsUsed =  $completedTaskClasses;
                    //$totalCreditsGiven = $totalCreditsForClassType * $paymentsMade;
                    $remaining_credits = $totalCreditsGiven - $totalCreditsUsed;
                
                    $lastCreditUsed = DB::table('task_classes as tc')
                                        ->join('task_class_user as tcu','tc.id','=','tcu.task_class_id')
                                        ->where('tc.task_class_type_id',$taskClassType->id)
                                        ->where('tcu.user_id',$user->id)
                                        ->where('tcu.completed',true)
                                        ->orderBy('tc.starts_at','Desc')
                                        ->select('tc.name as task_class_name','tc.starts_at as task_class_datetime')
                                        ->first();
                    if( $completedTaskClasses > 0 || $totalCreditsGiven > 0.0 ){
                        if($lastCreditUsed != null && $lastCreditUsed != ""){
                            $dataArray = [
                                'user_id' => $user->id,
                                'user_name' => $user->full_name,
                                'user_email' => $user->email,
                                 'task_class_type_id' => $taskClassType->id,
                                'task_class_type' => $taskClassType->type_name,
                                'credits_given' => $totalCreditsGiven,
                                'credits_used' =>$totalCreditsUsed,
                                'remaining_credits' => $remaining_credits,
                                'last_credits_used' => $lastCreditUsed->task_class_name."-".$lastCreditUsed->task_class_datetime
                            ];
                        }else{
                            $dataArray = [
                                'user_id' => $user->id,
                                'user_name' => $user->full_name,
                                'user_email' => $user->email,
                                 'task_class_type_id' => $taskClassType->id,
                                'task_class_type' => $taskClassType->type_name,
                                'credits_given' => $totalCreditsGiven,
                                'credits_used' =>$totalCreditsUsed,
                                'remaining_credits' => $remaining_credits,
                                'last_credits_used' => ""
                            ];
                        }
                        array_push($creditsCalculationData,$dataArray);
                    }
                }
            }
        }

        $user = Auth::user();
        $role = $user->role->role;
        $role = "admin";
        if($role == "admin"){
            $locationData = Location::where('is_deleted', false)->get();
        }
        elseif($role == "teacher"){
           $locationData = $user->locations()->get();
        }
        $locations = array();
        foreach($locationData as $location){
            $dataArray = ["location_id" => $location['id'],
                "location_name" => $location['location_name'],
            ];
            array_push($locations,$dataArray);
        }

        $usersCreditsData = "Available";
        $usersCredits = $creditsCalculationData;
        return view('credits_calculation.admin_index', compact('locations','usersCreditsData','usersCredits'));
    }

    public function editUsersCredits($userId, $taskClassTypeId,$lastCreditsUsed,$totalCreditsUsed){

        $user = User::where('id',$userId)->first();
        $getPaymentsMade = Credit::where(['customer_email' => $user->email,
                                          'task_class_type_id' => $taskClassTypeId])->get();
        $totalCreditsGiven = 0.0;
        foreach($getPaymentsMade as $getPaymentMade){
            $totalCreditsGiven += $getPaymentMade->credits_given;
        }
       
        $task_class_type_name = TaskClassType::where('id',$taskClassTypeId)->value('type_name');
        $user_id = $user->id;
        $user_name = $user->full_name;
        $user_email = $user->email;
        $task_class_type_id = $taskClassTypeId;
        $credits_given = $totalCreditsGiven;
        $credits_used = $totalCreditsUsed;
        $remaining_credits = $totalCreditsGiven -  $totalCreditsUsed;
        $last_credits_used = $lastCreditsUsed;

        return view('credits_calculation.admin_edit')->withUserid($user_id)
                                                     ->withUsername($user_name)
                                                     ->withUseremail($user_email)
                                                     ->withTaskclasstypeid($task_class_type_id)
                                                     ->withTaskclasstypename($task_class_type_name)
                                                     ->withCreditsgiven($credits_given)
                                                     ->withCreditsused($credits_used)
                                                     ->withRemainingcredits($remaining_credits)
                                                     ->withLastcreditsused($last_credits_used);
    }

    public function updateUserCredits(Request $request){
        date_default_timezone_set('America/Los_Angeles');
        $emailId = User::where('id', $request->user_id)->value('email');
        $task_class_type_id = $request->task_class_type_id;
        $creditsUsed = $request->credits_used;
        $creditsGiven = $request->credits_given;

        $new_given_credits = $request->give_credits ;
        $new_deducted_credits = $request->deduct_credits;
        if($request->give_credits == null || $request->give_credits == ""){
            $new_given_credits = 0.0;
        }
        if($request->deduct_credits == null || $request->deduct_credits == ""){
            $new_deducted_credits = 0.0;
        }

        $updated_credits = ($new_given_credits) - ($new_deducted_credits);
       
        $dt = Carbon::now(new DateTimeZone('America/Los_Angeles'));
        $dateToday = $dt->toDateString(); 

        $user_credits = new Credit();
        $user_credits->customer_email = $emailId;
        $user_credits->credits_given_date = $dateToday;
        $user_credits->credits_given = $updated_credits ;
        $user_credits->task_class_type_id = $task_class_type_id;
        $user_credits->description = $request->description;
        $user_credits->save();

        return redirect()->route('credits_calculations');
    }

    public function editUserCreditsFormForEachParent($parentId){
        $user = User::where('id',$parentId)->first();

        $parentEmailId = $user->email;
        $parentPhoneNumber = $user->phone_number;
        if($parentEmailId != null && $parentEmailId != ""){
            $getPaymentsMade = Credit::where(['customer_email' => $user->email])->get();
        }else{
            $getPaymentsMade = Credit::where(['phone_number' => $user->phone_number])->get();
        }
        
        $totalCreditsGiven = 0.0;
        foreach($getPaymentsMade as $getPaymentMade){
            $totalCreditsGiven += $getPaymentMade->credits_given;
        }
       
        $studentRoleId = Role::where('role','student')->value('id');
        $creditsUsed = DB::table('users as u')
                        ->join('task_class_user as tcu','tcu.user_id','=','u.id')
                        ->where('u.phone_number',$parentPhoneNumber)
                        ->where('u.role_id',$studentRoleId)
                        ->where('tcu.completed',1)
                        ->select('tcu.*')
                        ->select(DB::raw("count(tcu.completed) as credits_used"))
                        ->groupBy('u.id')
                        ->get();
        $credits_used = 0;
        foreach($creditsUsed as $creditUsed){
            $credits_used += $creditUsed->credits_used;
        }
        $remaining_credits = $totalCreditsGiven -  $credits_used;

        $credits_given = $totalCreditsGiven;
        $remaining_credits = $totalCreditsGiven -  $credits_used;
       
        return view('credits_calculation.admin_edits_credits_for_parent')->withUserid($parentId)
                                                    ->withPhone($parentPhoneNumber)
                                                    ->withEmail($parentEmailId)
                                                    ->withCreditsgiven($credits_given)
                                                    ->withCreditsused($credits_used)
                                                    ->withRemainingcredits($remaining_credits);
    }

    public function updateParentCredits(Request $request){
        $parent = User::where('id', $request->user_id)->first();
        $parentEmailId = $parent->email;
        $parentPhoneNumber = $parent->phone_number;
    
        $new_given_credits = $request->give_credits ;
        $new_deducted_credits = $request->deduct_credits;
        if($request->give_credits == null || $request->give_credits == ""){
            $new_given_credits = 0.0;
        }
        if($request->deduct_credits == null || $request->deduct_credits == ""){
            $new_deducted_credits = 0.0;
        }

        $updated_credits = ($new_given_credits) - ($new_deducted_credits);
       
        $dt = Carbon::now(new DateTimeZone('America/Los_Angeles'));
        $dateToday = $dt->toDateString(); 

        $user_credits = new Credit();
        $user_credits->customer_email = $parentEmailId ;
        $user_credits->phone_number = $parentPhoneNumber;
        $user_credits->credits_given_date = $dateToday;
        $user_credits->credits_given = $updated_credits;
        $user_credits->description = $request->description;
        $user_credits->save();

        return redirect()->back()->withSuccess('Credits Updated!');
        //return redirect()->route('edit_parents_credits',[$request->user_id]);
    }
}
