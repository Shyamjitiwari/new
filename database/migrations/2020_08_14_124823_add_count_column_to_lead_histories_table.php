<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountColumnToLeadHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('count')->default(0)->after('follow_up_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_histories', function (Blueprint $table) {
            $table->dropColumn('count');
        });
    }
}
