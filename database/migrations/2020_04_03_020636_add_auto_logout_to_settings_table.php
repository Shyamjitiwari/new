<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAutoLogoutToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert("INSERT INTO `settings` (`id`, `group`, `display_name`, `key`, `value`, `field_type`, `sort`, `status`, `updated_id`, `created_at`, `updated_at`) VALUES
            (13, 'system', 'Auto Logout (minutes)', 'auto_logout', '15', 'number', 1, 1, NULL, '2019-12-25 17:12:20', '2019-12-25 17:12:20');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
