<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampIdToTaskClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_classes', function (Blueprint $table) {
            $table->boolean('camp_id')->nullable()->default(null)->after('ends_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_classes', function (Blueprint $table) {
            $table->dropColumn('camp_id');
        });
    }
}
