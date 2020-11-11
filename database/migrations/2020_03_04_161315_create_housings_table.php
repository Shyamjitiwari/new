<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('housings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('api_id')->nullable()->default(null);
            $table->string('type')->nullable()->default(null);
            $table->string('lead_date');
            $table->string('apartment_names')->nullable()->default(null);
            $table->string('country_code')->nullable()->default(null);
            $table->string('service_type')->nullable()->default(null);
            $table->string('category_type')->nullable()->default(null);
            $table->string('locality_name')->nullable()->default(null);
            $table->string('city_name')->nullable()->default(null);
            $table->string('lead_name');
            $table->string('lead_email')->nullable()->default(null);
            $table->string('lead_phone');
            $table->string('project_name')->nullable()->default(null);
            $table->text('payload')->nullable()->default(null);
            $table->enum('status', ['new', 'old'])->default('new');
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
        Schema::dropIfExists('housings');
    }
}
