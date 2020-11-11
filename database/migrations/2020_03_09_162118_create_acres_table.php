<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acres', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedInteger('api_id')->nullable()->default(null);
            $table->timestamp('received_at')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('project_name')->nullable()->default(null);
            $table->string('project_details')->nullable()->default(null);
            $table->string('project_id')->nullable()->default(null);
            $table->string('query_info')->nullable()->default(null);
            $table->string('phone_verification_status')->nullable()->default(null);
            $table->string('email_verification_status')->nullable()->default(null);
            $table->string('identity')->nullable()->default(null);
            $table->string('property_code')->nullable()->default(null);
            $table->string('sub_user_name')->nullable()->default(null);
            $table->text('payload')->nullable()->default(null);
            $table->string('status')->default('new');
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
        Schema::dropIfExists('acres');
    }
}
