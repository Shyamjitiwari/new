<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->unsignedInteger('price');
            $table->unsignedInteger('size');
            $table->unsignedInteger('project_id');
            $table->string('sales_type')->nullable()->default(null);
            $table->unsignedInteger('bedroom')->nullable()->default(0);
            $table->unsignedInteger('bathroom')->nullable()->default(0);
            $table->unsignedInteger('balcony')->nullable()->default(0);
            $table->double('additional_room')->nullable()->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('created_id')->nullable()->default(null);
            $table->unsignedInteger('updated_id')->nullable()->default(null);
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
        Schema::dropIfExists('project_units');
    }
}
