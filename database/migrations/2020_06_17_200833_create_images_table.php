<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('thumbnail')->nullable()->default(null);
            $table->string('folder')->nullable()->default(null);
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
        Schema::dropIfExists('images');
    }
}
