<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->unsignedInteger('parent_id')->nullable()->default(null);
            $table->string('bg')->default('#6C757D')->comment('background color');
            $table->string('text')->default('#ffffff')->comment('text color');
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
        Schema::dropIfExists('lead_statuses');
    }
}
