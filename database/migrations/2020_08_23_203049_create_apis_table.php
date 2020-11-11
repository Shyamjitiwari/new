<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['magic_bricks', 'acers', 'housing']);
            $table->string('url');
            $table->string('key')->nullable()->default(null);
            $table->string('user_name')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('account_id')->nullable()->default(null);
            $table->string('user_group_id')->nullable()->default(null);
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
        Schema::dropIfExists('apis');
    }
}
