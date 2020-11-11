<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Auth;
use App\TaskClass;
use Carbon\Carbon;
use App\Domain\TokyFunctions;
use App\Domain\MailFunctions;
use App\Location;
use DateTime;
use DateTimeZone;
use App\Country;
use App\Holiday;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:commandfor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(TokyFunctions $toky, MailFunctions $mail)
    {
        date_default_timezone_set('America/Los_Angeles');
        $tomorrow = Carbon::tomorrow(new DateTimeZone('America/Los_Angeles'))->toDateString();
        $dateOfTomorrow = new DateTime($tomorrow);
        $dateOfTomorrow = $dateOfTomorrow->format('Y-m-d');
        $isAHoliday = false;

        $holidays = Holiday::all();
        foreach($holidays as $holiday){
            if($holiday->holiday_date == $dateOfTomorrow){
                $isAHoliday = true;
                break;
            }
        }
        if(!$isAHoliday){
            $taskClasses = TaskClass::where(['is_deleted' => false])->get();
            foreach($taskClasses as $taskClass){
                $location_id = $taskClass->location_id;
                $isLocationOnline = Location::where('id', $taskClass->location_id)->value('online');
                
                $dateOfTaskClass = $taskClass->starts_at;
                $dateOfTaskClass = new DateTime($dateOfTaskClass);
                $dateOfTaskClass = $dateOfTaskClass->format('Y-m-d');

                if($dateOfTomorrow == $dateOfTaskClass){
                    $users = $taskClass->users()->with('timezone')->wherePivot('absent',0)->get();
                    foreach($users as $user){
                        $role = $user->role->role;
                        if($role == "student"){
                            $phoneNumber = $user->phone_number;
                            $emailAddress = $user->email;
                            $user_timezone = $user->timezone->time_zone;

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
                                    'message' => $message.__('sms_and_email.link_to_online_classes'),
                                );
                                $mail->send_class_reminder("rida@codewithus.com","Unabsent Students",$data); 
                            }
                            $callingCode = Country::where('id',$user->country_id)->value('calling_code');
                            $phoneNumberWithCallingCode = $callingCode.$phoneNumber;
                        }
                    }
                }      
            }   
        }else{
            $taskClasses = TaskClass::where(['is_deleted' => false])->get();
            foreach($taskClasses as $taskClass){
                $location_id = $taskClass->location_id;
                $isLocationOnline = Location::where('id', $taskClass->location_id)->value('online');
                
                $dateOfTaskClass = $taskClass->starts_at;
                $dateOfTaskClass = new DateTime($dateOfTaskClass);
                $dateOfTaskClass = $dateOfTaskClass->format('Y-m-d');

                if($dateOfTomorrow == $dateOfTaskClass){
                    $users = $taskClass->users()->with('timezone')->get();
                    foreach($users as $user){
                        $role = $user->role->role;
                        if($role == "student"){
                            $phoneNumber = $user->phone_number;
                            $emailAddress = $user->email;
                            $user_timezone = $user->timezone->time_zone;

                            $class_datetime = new DateTime($taskClass->starts_at);
                            $class_datetime->setTimezone(new DateTimeZone($user_timezone));
                            $classDate = $class_datetime->format('Y-m-d');
                            $classTime = $class_datetime->format('h:i A');
                        
                            $message = __('sms_and_email.holiday_message',['Name' => $user->full_name, 'dateOfTomorrow' => $classDate]);
                            $message = stripslashes($message);
                        
                            if($emailAddress != null && $emailAddress != ""){
                                $data = array(
                                    'message' => $message." ".$phoneNumber,
                                );
                                $mail->send_holiday_reminder("rida@codewithus.com","My Holiday",$data); 
                            }
                            $callingCode = Country::where('id',$user->country_id)->value('calling_code');
                            $phoneNumberWithCallingCode = $callingCode.$phoneNumber;
                        }
                    }
                }      
            }   
        }
    }
}
