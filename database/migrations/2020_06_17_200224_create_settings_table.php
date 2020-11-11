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
            $table->id();
            $table->string('group');
            $table->string('display_name');
            $table->string('key')->unique();
            $table->text('value');
            $table->string('icon')->nullable()->default('cog');
            $table->string('field_type')->default('text')->comment('input field type');
            $table->unsignedBigInteger('sort')->default(1);
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1->show, 0->hidden');
            $table->unsignedBigInteger('updated_id')->nullable()->default(null);
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
