<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_hash')->unique();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->default(null);
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('referred_by');
            $table->unsignedBigInteger('referred_to')->nullable()->default(null);
            $table->boolean('signup_for_camp')->default(false);
            $table->boolean('signup_for_free_session')->default(false);
            $table->date('signup_date')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('referred_by')->references('id')->on('users');
            $table->foreign('referred_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('references');
    }
}
