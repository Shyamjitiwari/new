<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsFreeSessionInTaskClassUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_class_user', function (Blueprint $table) {
            $table->boolean('free')->default(0)->after('completed');
            $table->boolean('recurring')->default(1)->after('free');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_class_user', function (Blueprint $table) {
            $table->dropColumn('free');
            $table->dropColumn('recurring');
        });
    }
}
