<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTaskClassesTable extends Migration
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
            $table->boolean('recurring')->default(0)->after('is_free_session');
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
            $table->dropColumn('recurring');
        });
    }
}
