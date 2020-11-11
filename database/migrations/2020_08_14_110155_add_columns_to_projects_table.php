<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->date('possession')->nullable()->default(null)->after('pincode');
            $table->string('distance_in_kms')->nullable()->default(null)->after('possession');
            $table->unsignedInteger('nearby_location_id')->nullable()->default(null)->after('distance_in_kms');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('possession');
            $table->dropColumn('distance_in_kms');
            $table->dropColumn('nearby_location_id');
        });
    }
}
