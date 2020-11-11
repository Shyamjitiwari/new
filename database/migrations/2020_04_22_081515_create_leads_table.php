<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone_number')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->dateTime('form_submitted_at')->nullable()->default(null);
            $table->dateTime('free_session_date')->nullable()->default(null);
            $table->unsignedBigInteger('student_id')->nullable()->default(null);
            $table->unsignedBigInteger('lead_source_id');
            $table->unsignedBigInteger('lead_status_id');
            $table->boolean('is_deleted')->default(0);
            $table->unsignedBigInteger('created_id')->nullable()->default(null);
            $table->unsignedBigInteger('updated_id')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
