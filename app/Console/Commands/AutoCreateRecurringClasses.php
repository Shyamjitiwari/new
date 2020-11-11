<?php

namespace App\Console\Commands;

use App\Helper\Helper;
use App\Mail\RecurringClassMail;
use App\TaskClass;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutoCreateRecurringClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskclass:autorecurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates new class for next week based on the class in the current week';

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
    public function handle()
    {
        $taskClases = TaskClass::where('is_deleted', 0)
            ->with(['ages','teacher','students','topics'])
            ->where('recurring', 1)
            ->whereDate('starts_at', \Carbon\Carbon::now()->yesterday())
            ->get();

        if($taskClases->count())
        {
            foreach($taskClases as $class)
            {
                $teacher = User::where('role_id', 2)
                    ->whereHas('taskclasses', function($query) use($class){$query->where('task_class_id', $class->id);})
                    ->first();

                if(!$this->classExists($class, $teacher))
                {
                    $taskClass = TaskClass::create(
                        [
                            'name' => $class->name,
                            'location_id' => $class->location_id,
                            'is_free_session' => $class->is_free_session,
                            'recurring' => $class->recurring,
                            'task_class_type_id' => $class->task_class_type_id,
                            'starts_at' => Carbon::parse($class->starts_at)->addWeek(),
                            'ends_at' => Carbon::parse($class->ends_at)->addWeek(),
                        ]
                    );

                    $class->teacher ? $taskClass->teacher()->syncWithoutDetaching($class->teacher) : null;
                    $class->topics ? $taskClass->topics()->sync($class->topics) : null;
                    $class->topics ? $taskClass->ages()->sync($class->ages) : null;

                    if (!$class->is_free_session)
                    {
                        //send sms & email to all students whose class is marked as recurring
                        foreach($class->students as $student)
                        {
                            if($student->pivot->recurring) {
                                $taskClass->students()->attach($student, ['free' => $student->pivot->free, 'recurring' => $student->pivot->recurring]);
//                                $msg = "Our automated system has scheduled ".Helper::truncateName($student->user_name)." for their next class on
//                                ". $taskClass->starts_at .". If this was an error, or you want to reschedule, please text or email us back.";
                                //send sms
//                                $student->phone_number ? Helper::sendSMS($msg,$student->phone_number) : null;
                                //send email
//                                $student->email ? Mail::to($student->email)->send(new RecurringClassMail($msg)) : null;
                            }
                        }
                    }
                }
            }
        }
    }

    public function classExists($class, $teacher)
    {
        return TaskClass::where(
            [
                'name' => $class->name,
                'location_id' => $class->location_id,
                'is_free_session' => $class->is_free_session,
                'recurring' => $class->recurring,
                'task_class_type_id' => $class->task_class_type_id,
                'starts_at' => Carbon::parse($class->starts_at)->addWeek(),
                'ends_at' => Carbon::parse($class->ends_at)->addWeek(),
            ]
        )
            ->whereHas('teacher', function($query) use($teacher) {$query->where('user_id', $teacher->id);})
            ->count();
    }
}
