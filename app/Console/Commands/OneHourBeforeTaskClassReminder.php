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

class OneHourBeforeTaskClassReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onehourbefore:taskclassreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends a reminder to parents one hour before the class.';

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
        $today = Carbon::today(new DateTimeZone('America/Los_Angeles'))->toDateString();
        $dateOfToday = new DateTime($today);
        $dateOfToday = $dateOfToday->format('Y-m-d');

        $taskClasses = TaskClass::where('is_deleted', false)->get();
        foreach($taskClasses as $taskClass){
            $location_id = $taskClass->location_id;
            $isLocationOnline = Location::where('id', $taskClass->location_id)->value('online');
            
            $dateOfTaskClass = $taskClass->starts_at;
            $dateOfTaskClass = new DateTime($dateOfTaskClass);
            $dateOfTaskClass = $dateOfTaskClass->format('Y-m-d');
            // $dateOfTaskClass = new DateTime($dateOfTaskClass);
          
            // $diff = $dateOfTaskClass->diff($dateOfToday)->d;

            if($dateOfToday == $dateOfTaskClass){
                $now = Carbon::now();
                $now = new DateTime($now);

                $timeStampOfTaskClass = $taskClass->starts_at;
                $timeStampOfTaskClass = new DateTime($timeStampOfTaskClass);

                $difference_in_minutes = (strtotime($timeStampOfTaskClass->format('Y-m-d H:i:s')) - strtotime($now->format('Y-m-d H:i:s')))/60;
                if($difference_in_minutes <= 60 && $difference_in_minutes > 45){
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

                            $reschedule_link = __('sms_and_email.reschedule_classes_link');
                            if($isLocationOnline){
                                $message = __('sms_and_email.one_hour_before_class_reminder_for_online_class',['Name' => $user->full_name, 'classTime' => $classTime,'timeZone' => $user_timezone,'rescheduleLink' => $reschedule_link]);
                                $message = stripslashes($message);
                            }
                            else{
                                $location_address = Location::where('id', $location_id)->value('address');
                                $message = __('sms_and_email.one_hour_before_class_reminder_for_offline_class',['Name' => $user->full_name, 'classTime' => $classTime,'timeZone' => $user_timezone, 'Location' => $location_address,'rescheduleLink' => $reschedule_link]);
                                $message = stripslashes($message);
                            }
                            if($emailAddress != null && $emailAddress != ""){
                                // Send Email 
                                $data = array(
                                    'message' => $message,
                                );
                                $mail->send_class_reminder($emailAddress,$user->full_name, $data);
                                //$mail->send_class_reminder("rida@codewithus.com","One hour before", $data);
                            }
                            $callingCode = Country::where('id',$user->country_id)->value('calling_code');
                            $phoneNumberWithCallingCode = $callingCode.$phoneNumber;
                            $toky->sms_send($phoneNumberWithCallingCode, $message);
                        }
                    }
                }
            }      
        }
    }
}
