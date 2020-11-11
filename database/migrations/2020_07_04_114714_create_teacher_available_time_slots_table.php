<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherAvailableTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_available_time_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('teacher_id');
            $table->bigInteger('day_id');
            $table->bigInteger('time_id');
            $table->bigInteger('location_id');
            $table->bigInteger('limit')->default(15);
            $table->bigInteger('is_deleted');
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
        Schema::dropIfExists('teacher_availabel_time_slots');
    }
}
