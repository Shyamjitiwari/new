<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image_name')->nullable()->default(null);
            $table->string('email')->unique();
            $table->string('mobile')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedInteger('role_id')->nullable()->default(null);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
