<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id')->nullable()->default(null);
            $table->string('activity_type')->nullable()->default(null);
            $table->string('system_remark')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->text('payload')->nullable()->default(null);
            $table->string('type')->nullable()->default(null)->comment("Request Method");
            $table->text('http_user_agent')->nullable()->default(null)->comment("HTTP_USER_AGENT");
            $table->string('url')->nullable()->default(null)->comment("Site URL Accessed");
            $table->ipAddress('ip')->nullable()->default(null);
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('active->paid, inactive->unpaid');
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
        Schema::dropIfExists('activities');
    }
}
