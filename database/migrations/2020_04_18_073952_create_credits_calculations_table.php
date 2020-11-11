<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits_calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('credits_given')->default(0.0);
            $table->float('credits_used')->default(0.0);
            $table->string('customer_email');
            $table->string('product_id');
            $table->unsignedBigInteger('task_class_type_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('task_class_type_id')->references('id')->on('task_class_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits_calculations');
    }
}
