<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('lead_id');
            $table->unsignedInteger('historical_id')->nullable()->default(null);
            $table->string('historical_type')->nullable()->default(null);
            $table->text('remarks')->nullable()->default(null);
            $table->boolean('completed')->default(0)->comment('follow up status');
            $table->datetime('follow_up_at')->nullable()->default(null);
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
        Schema::dropIfExists('lead_histories');
    }
}
