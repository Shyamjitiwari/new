<?php

namespace App\Console\Commands;

use App\LeadHistory;
use App\Lead;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PostponeTodaysFollowup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todaysfollowup:postpone';

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
    public function handle()
    {
        $followup_leads = LeadHistory::where([['created_at','>',Carbon::today()],['follow_up_at','>=',Carbon::today()],['follow_up_at','<',Carbon::tomorrow()]])->get();

        foreach($followup_leads as $followup_lead){
            
            if(!$followup_lead->isFollowupHandled()){
                
                $followup_lead->count += 1;
                $followup_lead->save();

                //create next followup in history
                $lead_history = new LeadHistory;
                $lead_history->lead_id = $followup_lead->lead_id;
                $lead_history->follow_up_at = Carbon::parse($followup_lead->follow_up_at)->addDay();
                $lead_history->count = $followup_lead->count;
                $lead_history->created_id  = 1;
                $lead_history->save();

                //update followup in lead

                $lead = Lead::find($followup_lead->lead_id);
                $lead->follow_up_at = $lead_history->follow_up_at;
                $lead->save();
            }
        }
    }
}
