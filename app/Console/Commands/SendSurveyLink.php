<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Auth;
use App\User;
use App\TaskClass;
use Carbon\Carbon;
use App\Domain\TokyFunctions;
use App\Domain\MailFunctions;
use Illuminate\Support\Facades\DB;
use App\Location;
use DateTime;
use DateTimeZone;
use App\Role;

class SendSurveyLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:surveylink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Cron Job sends Survey Link to Users after regular time intervals';

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
    public function handle(TokyFunctions $toky,MailFunctions $mail)
    {
        $sm = "";
        $roleIdForStudent = Role::where('role', 'student')->value('id');
        $roleIdForParent = Role::where('role', 'parent')->value('id');
        date_default_timezone_set('America/Los_Angeles');

        $users = DB::table('users as u')
                ->join('task_class_user as tcu', 'tcu.user_id', '=', 'u.id')
                ->join('task_classes as tc','tc.id','=','tcu.task_class_id')
                ->where('u.role_id',$roleIdForStudent)
                ->where('tcu.completed', true)
                ->whereDate('tc.starts_at', '>=', Carbon::now(new DateTimeZone('America/Los_Angeles'))->startOfDay())
                ->select('u.*')
                ->get();
        $phone_numbers_array = array();
        $usersA = "";
        foreach($users as $user){
            if( ! in_array( $user->phone_number ,$phone_numbers_array) ){
                $completedClasses = User::find($user->id)->completed_taskclasses()->get();
                $totalCompletedClasses = count($completedClasses);
                if($totalCompletedClasses == 1 || $totalCompletedClasses == 4 || 
                   $totalCompletedClasses == 10 || $totalCompletedClasses == 20 ||
                   $totalCompletedClasses == 30){
                    
                    $teacherRoleId = Role::where('role','teacher')->value('id');
                    $latestCompletedClass = User::find($user->id)->completed_taskclasses()->latest('id')->first();
                    $teacherOfTheLatestCompletedClass = $latestCompletedClass->users()->where('role_id',$teacherRoleId)->get();
                    $idOfTeacherOfTheLatestCompletedClass = $teacherOfTheLatestCompletedClass->id;

                    $phoneNumber = $user->phone_number;
                    $countryId = $user->country_id;
                    $parent = User::where(['role_id' => $roleIdForParent,
                                        'phone_number' => $user->phone_number ])->first();
                    if($parent == null || $parent == ""){
                        $parentCreated = User::create([  
                            'user_name' => $phoneNumber,
                            'password' =>  bcrypt("pass"),
                            'phone_number' => $phoneNumber,
                            'country_id' => $countryId,
                            'role_id' => $roleIdForParent,
                        ]);
                        $parentId = $parentCreated->id;
                    }else{
                        $parentId = $parent->id;
                    }
                    $usersA = $usersA.$user->id.$user->full_name." - ".$totalCompletedClasses ." <br/>";
                    $smsMessage = __('sms_and_email.link_to_survey_in_cron_job');
                    $smsMessage = $smsMessage.$parentId."/".$idOfTeacherOfTheLatestCompletedClass."/".$user->id;
                    $phoneNumberWithCountryCode = $user->country_id.$phoneNumber;
                    $sm = $sm. $smsMessage . "<br/> ";
                    $toky->sms_send($phoneNumberWithCountryCode, $smsMessage);
                    array_push($phone_numbers_array,$user->phone_number);
                }
            }
        }

        $data = array(
            'message' => $sm,
        );
        $mail->send_class_reminder("rida@codewithus.com","Testing surveys", $data);
    }
}
