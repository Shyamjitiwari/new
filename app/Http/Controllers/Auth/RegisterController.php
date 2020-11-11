<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Torann\LaravelAsana;
use Torann\LaravelAsana\Facade;
use Torann\LaravelAsana\Facade\Asana;
use App\Location;
use App\Country;
use App\Timezone;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showRegistrationFormForStudentsPage1()
    {
        return view('auth.students_register_page1');
    }

    public function studentsRegistrationPage1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return back()->with('missing_full_name','Full name cannot be empty.');
        }
        else{
            $countries = Country::all();
            $selectedCountry = Country::first()->value('id');

            return view('auth.students_register_page2', compact('countries', 'selectedCountry'))
              ->withFullname($request->full_name)->withPassword($request->password)->withTimezone($request->time_zone)->withError("");
        }
    }
    
    public function showRegistrationFormForTeachers()
    {
        $countries = Country::all();
        $selectedCountry = Country::first()->value('id');

        return view('auth.teachers_register', compact('countries', 'selectedCountry'));
    }

    public function showRegistrationFormForAdmins(){
        $countries = Country::all();
        $selectedCountry = Country::first()->value('id');

        return view('auth.admins_register', compact('countries', 'selectedCountry'));
    }
    // When the registration forms gets submit, it calls RegisterController@register
    // function but we are putting an intermediate method here to perform some extra 
    // checks before the registration happens.
    public function registrationChecks(Request $request){
        if($request->role_type == "teacher" || $request->role_type == "admin" ){
            $location = Location::where('secret_code',$request->secret_code)->get();
            if(count($location) <= 0){
                return back()->with('incorrect_security_code','Incorrect Security Code.');
            }
            else{
                if($request->role_type == "admin" || $request->role_type == "teacher"){
                    $this->register($request);
                }
            }
        }
        elseif($request->role_type == "student"){

            $location = Location::where('secret_code',$request->secret_code)->get();
            if(count($location) > 0){
                $this->register($request);
            }
            else{
                return view('auth.students_register_page2')
                       ->withFullname($request->full_name)->withPassword($request->password)->withError("Provided Secret Code is wrong.");
            }
        }
        return redirect('/home');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        if($data['role_type'] == "student"){
            return Validator::make($data, [
                // 'user_name' => 'required|max:255|unique:users',
                'password' => 'required|min:3',
                'full_name' => 'required|max:255',
                'phone_number' => 'required',
                'secret_code' => 'required|min:4',
            ]);
        }
        if($data['role_type'] == "teacher"){
            return Validator::make($data, [
                // 'user_name' => 'required|max:255|unique:users',
                'full_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'phone_number' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);
        }
        if($data['role_type'] == "admin"){
            return Validator::make($data, [
                // 'user_name' => 'required|max:255|unique:users',
                'full_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'phone_number' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $roleId = Role::where('role',$data['role_type'])->value('id');
        $locationId = Location::where('secret_code',$data['secret_code'])->value('id');
        $countryId = (int)$data['country_id'];
        $timezone_id = Timezone::where('time_zone',$data['time_zone'])->value('id');

        if($data['role_type'] == "student"){
            $user = User::create([        
                'user_name' => $data['full_name'],
                'password' => bcrypt($data['password']),
                'full_name'=> $data['full_name'],
                'phone_number' => $data['phone_number'],
                'country_id' => $countryId,
                'timezone_id' => $timezone_id,
                'role_id' => $roleId,
            ]);
            $location = Location::find($locationId);
            $user->locations()->attach($location);

            $roleIdForParent = Role::where('role','parent')->value('id');
            $parentOfThisStudent = User::where(['role_id' => $roleIdForParent,
                                                'phone_number' =>$data['phone_number'] ])->first();
            if($parentOfThisStudent == null || $parentOfThisStudent == ""){
                User::create([  
                    'user_name' => $data['phone_number'],
                    'password' =>  bcrypt("pass"),
                    'phone_number' => $data['phone_number'],
                    'country_id' => $countryId,
                    'role_id' => $roleIdForParent,
                    'timezone_id' => $timezone_id,
                ]);  
            }
            return $user;
        }
        if($data['role_type'] == "teacher"){
            $user = User::create([  
                'user_name' => $data['full_name'],
                'full_name' => $data['full_name'],
                'password' => bcrypt($data['password']),
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'country_id' => $countryId,
                'role_id' => $roleId,
                'timezone_id' => $timezone_id,
            ]);
            $location = Location::find($locationId);
            $user->locations()->attach($location);
            return $user;
        }
        if($data['role_type'] == "admin"){
            $user = User::create([  
                'user_name' => $data['full_name'],
                'full_name' => $data['full_name'],
                'password' => bcrypt($data['password']),
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'country_id' => $countryId,
                'role_id' => $roleId,
                'timezone_id' => $timezone_id,
            ]);
            $location = Location::find($locationId);
            $user->locations()->attach($location);
            return $user;
        }
    }
}
