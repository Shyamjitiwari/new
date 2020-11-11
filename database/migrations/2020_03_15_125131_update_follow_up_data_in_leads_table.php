<?php

use App\Lead;
use App\LeadHistory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateFollowUpDataInLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $leads_history = LeadHistory::where('completed', 0)->where('follow_up_at','<>',null)->get();

        foreach($leads_history as $history){
            $lead = Lead::find($history->lead_id)->update(['follow_up_at' => $history->follow_up_at]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Lead::where('follow_up_at', '<>', null)->update(['follow_up_at' => null]);
    }
}
