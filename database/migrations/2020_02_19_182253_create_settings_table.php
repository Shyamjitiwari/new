<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group');
            $table->string('display_name');
            $table->string('key')->unique();
            $table->text('value');
            $table->string('field_type')->default('text')->comment('this is the type of input field which should be generated');
            $table->unsignedInteger('sort')->default(1);
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1->show, 0->hidden');
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
        Schema::dropIfExists('settings');
    }
}
