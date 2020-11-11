<?php

namespace App\Console\Commands;

use App\Helper\Helper;
use App\Mail\RecurringClassMail;
use App\TaskClass;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Domain\MailFunctions;
use App\Role;

class InCompleteMarkedClassesReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'incompleteMarkedClasses:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends reminder to all the teachers who had classes assigned to them but they are still marked as incomplete.';

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
    public function handle(MailFunctions $mail){
        $date = \Carbon\Carbon::today()->subDays(7);
        $today = \Carbon\Carbon::today();
        $studentsRoleId = Role::where('role','student')->value('id');
        $teachersRoleId = Role::where('role','teacher')->value('id');
        $teachers = User::where(['role_id' => $teachersRoleId,
                                 'is_deleted' => false])->get();
        foreach($teachers as $teacher){
            $teacherTaskClasses = $teacher->taskclasses()
                                                        ->where('starts_at','>=',$date)
                                                        ->where('starts_at','<=',$today)->get();
            $inCompleteTasks = "";
            foreach($teacherTaskClasses as $teacherTaskClass){
                $users = DB::table('task_classes as tc')
                         ->join('task_class_user as tcu','tc.id','=','tcu.task_class_id')
                         ->join('users as u','u.id','=','tcu.user_id')
                         ->where('tc.id', $teacherTaskClass->id)
                         ->where('tcu.completed',false)
                         ->where('u.role_id',$studentsRoleId)
                         ->select('u.full_name as student_full_name','tc.name as task_class_name','tc.starts_at as task_class_date')
                         ->get();
                foreach($users as $user){
                    $inCompleteTasks = $inCompleteTasks.$user->student_full_name." - ".$user->task_class_name." - ".$user->task_class_date."<br/>";
                }
            }
            $data_array = array(
                'teachers_name' => $teacher->full_name,
                'message' => $inCompleteTasks.'</br>',
            );
            $mail->send_teachers_reminder_of_incomplete_marked_classes($teacher->email, $data_array);
        }
    } 
}
