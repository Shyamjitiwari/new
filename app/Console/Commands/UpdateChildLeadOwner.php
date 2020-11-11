<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateChildLeadOwner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChildLeadOwner:update';

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
                if($child->created_id !=  $lead->created_id) {
                    echo('Current lead owner ' . $child->created_id . 'updating to ' . $lead->created_id);
                    $child->created_id = $lead->created_id;
                    $child->save();
                }
            }
        }
    }
}
