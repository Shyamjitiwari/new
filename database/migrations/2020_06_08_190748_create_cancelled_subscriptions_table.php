<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelledSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancelled_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subscription_id');
            $table->unsignedBigInteger('user_id')->default(null)->nullable();
            $table->text('reason_of_cancellation');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cancelled_subscriptions');
    }
}
