<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeadStatusinLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
