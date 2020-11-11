<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use phpDocumentor\Reflection\Types\Null_;
use App\Domain\TokyFunctions;
use App\Country;

class UsernameAndPasswordResetController extends Controller
{
    public function getCountryCallingCodes(){
        $countries = Country::all();
        $selectedCountry = Country::first()->value('id');
        return response()->json(['countryCallingCodes' => $countries,'selectedCountry' => $selectedCountry ],200);
    }
    public function forgotUserNameForm(){
        return view('auth.custom_resets.forgot_username');
    }
    public function getUserNames(Request $request){
        $users = User::where(['phone_number' => $request->phone_number,
                              'is_deleted' => false])->get();
        $userNames = array();
        if(count($users)>0){
            foreach($users as $user){
                $condition = stripos($user->full_name, $request->name) ;
                if($condition !== false){
                    $dataArray = ["username" => $user->user_name,
                                  "fullname" => $user->full_name,
                    ];
                    array_push($userNames, $dataArray);   
                }
            }
        }
        if(count($userNames) > 0){
            return $userNames; 
        } 
        else{
            return response()->json(['response_msg'=>'No Usernames exists with this information'],200);
        }                   
    }
    public function getUserNamesUsingPhoneNumbers(Request $request){
        $users = User::where(['phone_number' => $request->phone_number,
                              'country_id' => $request->country_id,
                              'is_deleted' => false])->get();
        $userNames = array();
        if(count($users)>0){
            foreach($users as $user){
                $role = Role::where('id', $user->role_id)->value('role');

                if($role != "parent"){
                    if($user->password == null || $user->password ==""){
                        $isPasswordAvailable = "No";
                    }
                    else{
                        $isPasswordAvailable = "Yes";
                    }
                    if($role == "teacher"){
                        $user_full_name = $user->full_name." (Teacher)";
                    }
                    else if($role == "admin"){
                        $user_full_name = $user->full_name." (Admin)";
                    }
                    else if($role == "student"){
                        $user_full_name = $user->full_name;
                    }
                    $dataArray = [  "username" => $user->user_name,
                                    "fullname" => $user_full_name,
                                    "phone_number" => $user->phone_number,
                                    "is_password_available" => $isPasswordAvailable,
                    ];
                    array_push($userNames, $dataArray); 
                }            
            }
        }
        if(count($userNames) > 0){
            return $userNames; 
        } 
        else{
            return response()->json(['response_msg'=>'No Usernames exists with this information'],200);
        }                   
    }

    public function setUserPassword(Request $request){
        $user = User::where(['user_name' => $request->user_name,
                             'full_name' => $request->full_name,
                             'phone_number' => $request->phone_number,
                             'is_deleted' => false])->first();
        $user->password=bcrypt($request->password);
        $user->update();
        return response()->json(['response_msg'=>'Password Saved'],200);
    }

    public function sendPasswordResetToken(Request $request,TokyFunctions $toky){
        $countryId = User::where('phone_number',$request->phone_number)->value('country_id');
        $countryCallingCode = Country::where('id', $countryId)->value('calling_code');
        $phoneNumber = $countryCallingCode.$request->phone_number;

        $PhoneNumberMultipliedWithTwo =(string)((int)$request->phone_number) * 2;
        $last4Digits = substr($PhoneNumberMultipliedWithTwo, -4);
        $text = $last4Digits;
        $toky_response = $toky->sms_send($phoneNumber, $text);
        
        return response()->json(['password_reset_token' => ''.$last4Digits.''],200);
    }

    public function resetPassword(Request $request){
        $user = User::where(['full_name' => $request->user_name,
                             'phone_number' => $request->phone_number])->first();
        if($user == null || $user == ""){
            $user = User::where(['user_name' => $request->user_name,
                                 'phone_number' => $request->phone_number])->first();
        }
        $user->password = bcrypt($request->resetPassword);
        $user->save();

        return response()->json(['response_msg'=> "Password Updated"],200);
    }
    
}
