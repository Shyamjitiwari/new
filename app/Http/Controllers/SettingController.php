<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\TaskClass;
use Carbon\Carbon;
use App\Domain\TokyFunctions;
use App\Domain\MailFunctions;
use App\Location;
use DateTime;
use DateTimeZone;
use App\Country;
use App\User;
use Stripe\Stripe;
use App\Stripe as StripeModel;
use App\Credit;
use App\TaskClassType;
use App\Configuration;
use App\CreditsCalculation;
use App\Role;
use App\Domain\Camps_prices_and_time;
use App\Domain\Camps_strings;
use App\Domain\Career_strings;
use App\Domain\Coding_classes_strings;
use App\Domain\FAQs_strings;
use App\Domain\Home_page_strings;
use App\Domain\Localized_strings_functions;
use App\Domain\NY_page_strings;
use App\Domain\Options_for_classes_strings;
use App\Domain\Partners_page_strings;
use App\Domain\Questions_strings;
use App\Domain\Testimonials_strings;


class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin');
    }

    public function settingsPage(){
        $user = Auth::user();
        $role = $user->role->role;
        switch ($role) {
            case 'admin':
                return view('settings.admin_settings');
                break;
        }
    }

    public function sendReminderSMSAndEmail(TokyFunctions $toky, MailFunctions $mail){
        date_default_timezone_set('America/Los_Angeles');
        $tomorrow = Carbon::tomorrow(new DateTimeZone('America/Los_Angeles'))->toDateString();
        $dateOfTomorrow = new DateTime($tomorrow);
        $dateOfTomorrow = $dateOfTomorrow->format('Y-m-d');

        $taskClasses = TaskClass::where(['is_deleted' => false])->get();
        foreach($taskClasses as $taskClass){
            $location_id = $taskClass->location_id;
            $isLocationOnline = Location::where('id', $taskClass->location_id)->value('online');
            
            $dateOfTaskClass = $taskClass->starts_at;
            $dateOfTaskClass = new DateTime($dateOfTaskClass);
            $dateOfTaskClass = $dateOfTaskClass->format('Y-m-d');

            // $dateOfTaskClass = new DateTime($dateOfTaskClass);
          
            // $diff = $dateOfTaskClass->diff($dateOfTomorrow)->d;

            if($dateOfTomorrow == $dateOfTaskClass){
                $users = $taskClass->users()->get();
                foreach($users as $user){
                    $role = $user->role->role;
                    if($role == "student"){
                        $phoneNumber = $user->phone_number;
                        $emailAddress = $user->email;
                        $user_timezone = $user->timezone;

                        $class_datetime = new DateTime($taskClass->starts_at);
                        $class_datetime->setTimezone(new DateTimeZone($user_timezone));
                        $classDate = $class_datetime->format('Y-m-d');
                        $classTime = $class_datetime->format('h:i A');
                       
                        if($isLocationOnline){
                            $message = __('sms_and_email.one_day_before_class_reminder_for_online_class',['Name' => $user->full_name, 'classDate' => $classDate, 'classTime' => $classTime, 'timeZone' => $user_timezone]);
                            $message = stripslashes($message);
                        }
                        else{
                            $location_address = Location::where('id', $location_id)->value('address');
                            $message = __('sms_and_email.one_day_before_class_reminder_for_offline_class',['Name' => $user->full_name, 'classDate' => $classDate, 'classTime' => $classTime,'timeZone' => $user_timezone, 'Location' => $location_address]);
                            $message = stripslashes($message);
                        }
                        if($emailAddress != null && $emailAddress != ""){
                            $data = array(
                                'message' => $message,
                            );
                            //$mail->send_class_reminder($emailAddress,$user->full_name,$data); 
                            $mail->send_class_reminder("rida@codewithus.com","Noore", $data); 
                        }
                        $callingCode = Country::where('id',$user->country_id)->value('calling_code');
                        $phoneNumberWithCallingCode = $callingCode.$phoneNumber;
                        //$toky->sms_send($phoneNumberWithCallingCode, $message);
                    }
                }
            }      
        
        }  
        return response()->json(['response_msg'=>'Reminder sent.'],200);
    }


    public function sendReminderSMSAndEmailOneHourBeforeClass(TokyFunctions $toky, MailFunctions $mail){
        date_default_timezone_set('America/Los_Angeles');
        $today = Carbon::today(new DateTimeZone('America/Los_Angeles'))->toDateString();
        $dateOfToday = new DateTime($today);

        $taskClasses = TaskClass::where('is_deleted', false)->get();
        foreach($taskClasses as $taskClass){
            $location_id = $taskClass->location_id;
            $isLocationOnline = Location::where('id', $taskClass->location_id)->value('online');
            
            $dateOfTaskClass = $taskClass->starts_at;
            $dateOfTaskClass = new DateTime($dateOfTaskClass);
            $dateOfTaskClass = $dateOfTaskClass->format('Y-m-d');
            $dateOfTaskClass = new DateTime($dateOfTaskClass);
          
            $diff = $dateOfTaskClass->diff($dateOfToday)->d;

            if($diff == 0){
                $now = Carbon::now();
                $now = new DateTime($now);

                $timeStampOfTaskClass = $taskClass->starts_at;
                $timeStampOfTaskClass = new DateTime($timeStampOfTaskClass);

                $difference_in_minutes = (strtotime($timeStampOfTaskClass->format('Y-m-d H:i:s')) - strtotime($now->format('Y-m-d H:i:s')))/60;
                if($difference_in_minutes <= 60 && $difference_in_minutes > 45){
                    $users = $taskClass->users()->get();
                    foreach($users as $user){
                        $role = $user->role->role;
                        if($role == "student"){
                            $phoneNumber = $user->phone_number;
                            $emailAddress = $user->email;
                            $user_timezone = $user->timezone;

                            $class_datetime = new DateTime($taskClass->starts_at);
                            $class_datetime->setTimezone(new DateTimeZone($user_timezone));
                            $classDate = $class_datetime->format('Y-m-d');
                            $classTime = $class_datetime->format('h:i A');
                            // $classDate = date('Y-m-d', strtotime($taskClass->starts_at));
                            // $classTime = date('h:i A', strtotime($taskClass->starts_at));
                            
                            if($isLocationOnline){
                                $message = __('sms_and_email.one_hour_before_class_reminder_for_online_class',['Name' => $user->full_name, 'classTime' => $classTime,'timeZone' => $user_timezone]);
                                $message = stripslashes($message);
                            }
                            else{
                                $location_address = Location::where('id', $location_id)->value('address');
                                $message = __('sms_and_email.one_hour_before_class_reminder_for_offline_class',['Name' => $user->full_name, 'classTime' => $classTime,'timeZone' => $user_timezone, 'Location' => $location_address]);
                                $message = stripslashes($message);
                            }
                            if($emailAddress != null && $emailAddress != ""){
                                // Send Email 
                                $data = array(
                                    'message' => $message,
                                );
                                $mail->send_class_reminder($emailAddress,$user->full_name, $data);
                            }
                            $callingCode = Country::where('id',$user->country_id)->value('calling_code');
                            $phoneNumberWithCallingCode = $callingCode.$phoneNumber;
                            $toky->sms_send($phoneNumberWithCallingCode, $message);
                        }
                    }
                }
            }      
        }
        
        return response()->json(['response_msg'=>'Reminder Sent'],200);
    }

    public function createRecurringClasses(){

        $taskClases = TaskClass::where('is_deleted', 0)
            ->with(['ages','teacher','students','topics'])
            ->where('recurring', 1)
            ->whereDate('starts_at', \Carbon\Carbon::now()->yesterday())
            ->get();

        if($taskClases->count())
        {
            foreach($taskClases as $task)
            {
                if(!$this->classExists($task)) {
                    $taskClass = TaskClass::create(
                        [
                            'name' => $task->name,
                            'location_id' => $task->location_id,
                            'is_free_session' => $task->is_free_session,
                            'recurring' => $task->recurring,
                            'task_class_type_id' => $task->task_class_type_id,
                            'starts_at' => Carbon::parse($task->starts_at)->addWeek(),
                            'ends_at' => Carbon::parse($task->ends_at)->addWeek(),
                        ]
                    );

                    if (!$task->is_free_session) {
                        $task->students ? $taskClass->students()->sync($task->students) : null;
                    }

                    $task->teacher ? $taskClass->users()->attach($task->teacher) : null;
                    $task->topics ? $taskClass->topics()->sync($task->topics) : null;
                    $task->topics ? $taskClass->ages()->sync($task->ages) : null;
                }

            }
        }

        return response()->json(['response_msg'=>'Data saved'],200);
    }

    public function classExists($task)
    {
        return TaskClass::where(
            [
                'name' => $task->name,
                'location_id' => $task->location_id,
                'is_free_session' => $task->is_free_session,
                'recurring' => $task->recurring,
                'task_class_type_id' => $task->task_class_type_id,
                'starts_at' => Carbon::parse($task->starts_at)->addWeek(),
                'ends_at' => Carbon::parse($task->ends_at)->addWeek(),
            ]
        )->count();
    }

    public function getTodaysPayments(){
        $stripeLiveSecretKey = Configuration::where('key', 'stripe_live_secret_key')->value('value');
        date_default_timezone_set('America/Los_Angeles');
        $today = Carbon::yesterday();
        //$today = Carbon::yesterday();
        $todayUT = strtotime($today);
        // $now = Carbon::now();
        // $nowDateTime =date('Y-m-d H:i:s',strtotime($todayUT));
        \Stripe\Stripe::setApiKey($stripeLiveSecretKey);

        $listOfPayments = \Stripe\PaymentIntent::all(['created[gte]' => $todayUT]);

        foreach($listOfPayments as $paymentIntent){
            if($paymentIntent->charges->data != null && $paymentIntent->charges->data != ""){
                $payment = $paymentIntent->charges->data[0];
                $emailId = $payment->receipt_email;
                $amount = ($payment->amount)/100;
                $paymentId = $payment->payment_method;

                if($payment->invoice != null){
                    $invoice = \Stripe\Invoice::retrieve($payment->invoice);
                    $product_id = $invoice->lines->data[0]->plan->id;
                }else{

                    $product_id = $paymentIntent->metadata->product_id;
                }
            
                if($product_id != null && $product_id != ""){
                    $stripeData = StripeModel::where('product_id',$product_id)->first();
                    $credits = $stripeData->number_of_credits;
                    $taskClassTypeId = $stripeData->task_class_type_id;
                    // $credits = 4;
                    // $taskClassTypeId = 1;

                    $creditObj = new Credit();
                    $creditObj->credits_given = $credits;
                    $creditObj->credits_given_date =$nowDateTime;
                    $creditObj->customer_email = $emailId;
                    $creditObj->payment_id = $paymentId;
                    $creditObj->product_id = $product_id;
                    $creditObj->task_class_type_id = $taskClassTypeId;
                    $creditObj->save();  

                    $roleId = Role::where('role', 'parent')->value('id');
                    $userPhoneNumber = User::where(['role_id' => $roleId,
                                                    'email' => $emailId,])->value('phone_number');

                    $creditsCalculation = CreditsCalculation::where(['phone_number' => $userPhoneNumber,
                                                                     'product_id' => $product_id,
                                                                     'task_class_type_id' => $taskClassTypeId])->first();
                    if($creditsCalculation != null && $creditsCalculation != ""){
                        if($creditsCalculation->customer_email == null || $creditsCalculation->customer_email == ""){
                            $creditsCalculation->customer_email = $emailId;
                            $creditsCalculation->product_id = $product_id;
                        }
                        $previous_credits = $creditsCalculation->credits_given;
                        $new_credits = $previous_credits + $credits;

                        $creditsCalculation->credits_given = $new_credits;
                        $creditsCalculation->save();
                    }else{
                        $creditsCalculation = new CreditsCalculation();
                        $creditsCalculation->credits_given = $credits;
                        $creditsCalculation->customer_email = $emailId;
                        $creditsCalculation->phone_number = $userPhoneNumber;
                        $creditsCalculation->product_id = $product_id;
                        $creditsCalculation->task_class_type_id = $taskClassTypeId;
                        $creditsCalculation->save();
                    }
                }
            }
        }
    }

    public function addLocalizedStringsForWebsiteIntoTheTable(){
        Camps_prices_and_time::add_camps_prices_and_time_strings_into_database();
        Camps_strings::add_camps_strings_into_database();
        Career_strings::add_career_strings_into_database();
        Coding_classes_strings::add_coding_classes_strings_into_database();
        FAQs_strings::add_faqs_strings_into_database();
        Home_page_strings::add_home_page_strings_into_database();
        NY_page_strings::add_NY_page_strings_into_database();
        Options_for_classes_strings::add_options_for_classes_strings_into_database();
        Partners_page_strings::add_partner_page_strings_into_database();
        Questions_strings::add_questions_strings_into_database();
        Testimonials_strings::add_testimonial_strings_into_database();
    }

}
