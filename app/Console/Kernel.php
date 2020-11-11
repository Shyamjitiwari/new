<?php

namespace App\Console;

use App\Helper\Acre;
use App\Helper\MagicBricks;
use Carbon\Carbon;
use App\Helper\Helper;
use Illuminate\Support\Facades\Storage;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {Helper::processHousingLeads(1);})->everyFiveMinutes();

        $schedule->call(function() {Acre::processAcreLeads();})->everyTenMinutes();

        $schedule->call(function() {MagicBricks::processLeads();})->everyTenMinutes();

        $schedule->command('logout:inactive')->everyMinute();

        $schedule->command('ChildLeadOwner:update')->dailyAt('23:49');
        $schedule->command('ChildLeadStatus:update')->dailyAt('23:50');
        $schedule->command('ChildLeadOwner:update')->dailyAt('23:55');
        $schedule->command('todaysfollowup:postpone')->dailyAt('00:01');
        $schedule->command('ChildLeadOwner:update')->dailyAt('23:49');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
