<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnInFreeSessionBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('free_session_bookings', function (Blueprint $table)
        {
            $table->dropColumn('student_age');
            $table->date('dob')->nullable()->default(null)->after('student_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free_session_bookings', function (Blueprint $table)
        {
            $table->date('student_age')->nullable()->default(null)->after('student_name');
            $table->dropColumn('dob');
        });
    }
}
