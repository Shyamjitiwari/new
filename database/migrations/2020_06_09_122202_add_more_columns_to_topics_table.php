<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsToTopicsTable extends Migration
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
            $table->text('description')->nullable()->default(null)->after('name');
            $table->unsignedInteger('sort')->nullable()->default(100)->after('in_camps');
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
            $table->dropColumn('description');
            $table->dropColumn('sort');
        });
    }
}
