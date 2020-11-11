<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForCountryCodeInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->string('country_calling_code')->nullable()->default(null)->after('email');
            $table->string('country')->nullable()->default(null)->after('dob');
            $table->string('timezone')->nullable()->default(null)->after('postal_address');
            $table->string('language')->nullable()->default(null)->after('timezone'); 
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
