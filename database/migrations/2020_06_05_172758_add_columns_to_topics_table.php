<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table)
        {
            $table->boolean('in_camps')->default(1)->after('free_session');
            $table->string('image_name')->nullable()->default('default.png')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table)
        {
            $table->dropColumn('image_name');
            $table->dropColumn('in_camps');
        });
    }
}
