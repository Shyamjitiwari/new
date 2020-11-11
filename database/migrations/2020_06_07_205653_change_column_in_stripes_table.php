<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\TaskClassFrequency;
use App\Currency;

class ChangeColumnInStripesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        TaskClassFrequency::create([
            'name' => 'Weekly',
        ]);

        Currency::create([
            'name' => 'USD',
        ]);
        
        Schema::table('stripes', function (Blueprint $table) {
            $table->dropColumn('frequency');
            $table->unsignedBigInteger('frequency_id')->default(1)->after('description');

            $table->dropColumn('currency');
            $table->unsignedBigInteger('currency_id')->default(1)->after('frequency_id');

            $table->foreign('frequency_id')->references('id')->on('task_class_frequencies');
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
