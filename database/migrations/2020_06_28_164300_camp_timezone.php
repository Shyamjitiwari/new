<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampTimezone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp_timezone', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('camp_id');
            $table->unsignedBigInteger('timezone_id');
            $table->timestamps();

            $table->foreign('camp_id')->references('id')->on('camps');
            $table->foreign('timezone_id')->references('id')->on('timezones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
