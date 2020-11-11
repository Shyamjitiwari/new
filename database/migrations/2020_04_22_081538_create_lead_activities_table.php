<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('activity_id')->nullable()->default(null);
            $table->string('activity_type')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->boolean('completed')->default(0)->comment('follow up status');
            $table->datetime('follow_up_at')->nullable()->default(null);
            $table->boolean('is_deleted')->default(0);
            $table->unsignedBigInteger('created_id')->nullable()->default(null);
            $table->unsignedBigInteger('updated_id')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_activities');
    }
}
