<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Role;
use App\Domain\TokyFunctions;
use App\Country;
use App\Timezone;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function loginFormForUsersExceptParents(){
        return view('auth.users_login');
    }
    public function parentsPhoneNumberForm(){
        $countries = Country::all();
        $selectedCountry = Country::first()->value('id');

        return view('auth.parents_phone_no_form', compact('countries', 'selectedCountry'));
    }
    public function parentsLoginTokenForm(Request $request,TokyFunctions $toky){
        $session_name = "Session ".$request->phone_number;
        $countryCallingCode = Country::where('id', $request->country_id)->value('calling_code');
        $phoneNumber = $countryCallingCode.$request->phone_number;
        $PhoneNumberMultipliedWithTwo =(string)((int)$request->phone_number) * 2;
        $last4Digits = substr($PhoneNumberMultipliedWithTwo, -4);
        $text = $last4Digits;
        Session::put($session_name, $text);
		$toky->sms_send($phoneNumber, "Secret login code: ".$text);
        return view('auth.parents_login_token_form')
                    ->withPhonenumber($request->phone_number)->withCountryid($request->country_id)->withError("");
    }
    public function parentsLogin(Request $request){
        $session_name = "Session ".$request->user_name;
        $validToken = Session::get($session_name);

        if($request->code == $validToken) {
            $roleId = Role::where('role','parent')->value('id');
            $countryId = (int)$request->country_id;
            $timezone_id = Timezone::where('time_zone',$request->time_zone)->value('id');
            $user = User::where('user_name',$request->user_name)->value('id');
            if($user == null){
                User::create([  
                    'user_name' => $request->user_name,
                    'password' =>  bcrypt("pass"),
                    'phone_number' => $request->user_name,
                    'country_id' => $countryId,
                    'role_id' => $roleId,
                    'timezone_id' => $timezone_id,
                ]);          
            }
            Session::forget($session_name);  
            return $this->login($request);      
        } else {
            return view('auth.parents_login_token_form')->withPhonenumber($request->user_name)->withCountryid($request->country_id)->withError('The Security Code provided is wrong.');
        }
    }

    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
}
