<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnToFreeSessionTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('free_session_time_slots', function (Blueprint $table)
        {
            $table->unsignedInteger('limit')->default(15)->after('is_private');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('limit', function (Blueprint $table)
        {
            $table->dropColumn('student_limit');
        });
    }
}
