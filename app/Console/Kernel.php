<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       'App\Console\Commands\OneDayBeforeTaskClassReminder',
       'App\Console\Commands\OneHourBeforeTaskClassReminder',
       'App\Console\Commands\PaymentsReceivedToday',
       'App\Console\Commands\AutoCreateRecurringClasses',
       'App\Console\Commands\SendSurveyLink',
       'App\Console\Commands\InCompleteMarkedClassesReminder',
       //'App\Console\Commands\TestCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->command('onedaybefore:taskclassreminder')->dailyAt('00:00');
       $schedule->command('onehourbefore:taskclassreminder')->hourly();
       $schedule->command('payments_received:today')->dailyAt('06:00');
       $schedule->command('taskclass:autorecurring')->dailyAt('12:00');
       $schedule->command('send:surveylink')->dailyAt('04:00');
       $schedule->command('incompleteMarkedClasses:reminder')->dailyAt('00:00');
       //$schedule->command('test:commandfor')->dailyAt('00:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
