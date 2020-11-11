<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Currency;
class AddCurrencyInTimezonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $currency = Currency::where('id',1)->first();
        if($currency == null){
            $currency = new Currency();
            $currency->name = "USD";
            $currency->save();
        }
        Schema::table('timezones', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id')->default(1)->after('locale_id');

            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
