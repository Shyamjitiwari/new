<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('setting_key');
            $table->string('value');
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
        Schema::dropIfExists('setting_lists');
    }
}
