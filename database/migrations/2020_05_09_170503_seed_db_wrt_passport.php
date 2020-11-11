<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class SeedDbWrtPassport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert("INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
            (1, 1, '2020-05-09 01:57:52', '2020-05-09 01:57:52');
        ");
        DB::insert("INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
            (1, NULL, 'Laravel Personal Access Client', 'qGt8DopqUcQxYgXGNynlqjT3hC4v33IDtkVJMQdN', 'http://localhost', 1, 0, 0, '2020-05-09 01:57:52', '2020-05-09 01:57:52'),
            (2, NULL, 'Laravel Password Grant Client', '870iTNHowoeaEDnL5PbH3LLyYm3yAjugioUAQ3Bq', 'http://localhost', 0, 1, 0, '2020-05-09 01:57:52', '2020-05-09 01:57:52');
        ");

        // calling artisan command to generate passport keys for all fresh installations
        Artisan::call('passport:keys');

        $u = new \App\User;
        $u->user_name = 'Api User';
        $u->full_name = 'Api User';
        $u->role_id = 1;
        $u->email = 'api_user@codewithus.com';
        $u->password = bcrypt('123123123');
        $u->phone_number = 1234567890;
        $u->save();


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
