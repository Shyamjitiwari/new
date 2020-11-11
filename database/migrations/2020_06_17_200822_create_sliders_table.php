<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->string('description_line1')->nullable()->default(null);
            $table->string('description_line2')->nullable()->default(null);
            $table->string('description_line3')->nullable()->default(null);
            $table->string('hyper_link')->nullable()->default(null);
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
        Schema::dropIfExists('sliders');
    }
}
