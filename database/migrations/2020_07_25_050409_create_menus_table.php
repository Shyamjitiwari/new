<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable()->default(null);
            $table->string('name');
            $table->enum('type', ['top', 'bottom'])->default('top');
            $table->string('page_id')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
            $table->enum('target',['_blank', '_self'])->nullable()->default('_blank');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->bigInteger('created_id')->nullable()->default(null);
            $table->bigInteger('updated_id')->nullable()->default(null);
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
        Schema::dropIfExists('menus');
    }
}