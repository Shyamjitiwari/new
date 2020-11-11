<?php

namespace App\Console\Commands;

use App\Constants\ActivityLabels;
use App\Helper\Helper;
use App\Helper\LogActivity;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LogoutInactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logout:inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Logs out inactive user after a specified';

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
        $users = Helper::getLoggedInUsers();

        foreach ($users as $user)
        {
            $isUserInactive = Helper::isUserInactive($user);

            if($isUserInactive)
            {
                Helper::revokeToken($user);

                LogActivity::add($user,'ActivityLabels::_LOGOUT_SYSTEM');
            }
        }
    }


}
