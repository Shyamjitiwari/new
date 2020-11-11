<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateChildLeadStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChildLeadStatus:update';

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
        $leads = \App\Lead::where('parent_id', null)->with('children')->get();

        foreach($leads as $lead)
        {
            foreach($lead->children as $child)
            {
                if($child->lead_status_id !=  $lead->lead_status_id) {
                    echo('Current lead status ' . $child->lead_status_id . 'updating to ' . $lead->lead_status_id);
                    $child->lead_status_id = $lead->lead_status_id;
                    $child->save();
                }
            }
        }
    }
}
