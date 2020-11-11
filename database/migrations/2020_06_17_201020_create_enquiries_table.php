<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('subject');
            $table->text('description');
            $table->ipAddress('ip')->nullable()->default(null);
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('active->paid, inactive->unpaid');
            $table->unsignedBigInteger('updated_id')->nullable()->default(null);
            $table->unsignedBigInteger('created_id')->nullable()->default(null);
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
        Schema::dropIfExists('enquiries');
    }
}
