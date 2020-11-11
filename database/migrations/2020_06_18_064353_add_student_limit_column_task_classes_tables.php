<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentLimitColumnTaskClassesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_classes', function (Blueprint $table)
        {
            $table->unsignedInteger('student_limit')->default(10)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_classes', function (Blueprint $table)
        {
            $table->dropColumn('student_limit');
        });
    }
}
