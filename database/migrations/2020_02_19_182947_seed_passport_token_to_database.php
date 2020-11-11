<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SeedPassportTokenToDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert("INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
            (1, NULL, 'TEA Personal Access Client', 'M8NgVQkCxcQbpoBlfnRVr7Ktg0WwcnkZw56Q0uSH', 'http://localhost', 1, 0, 0, '2020-04-06 04:37:44', '2020-04-06 04:37:44'),
            (2, NULL, 'TEA Password Grant Client', 'mjx2A6e6PnEJy7rw1cLS7JIeCaX5nMOECLkxubFO', 'http://localhost', 0, 1, 0, '2020-04-06 04:37:44', '2020-04-06 04:37:44');
        ");

        DB::insert("INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
            (1, 1, '2020-04-06 04:37:44', '2020-04-06 04:37:44');
        ");


        // calling artisan command to generate passport keys for all fresh installations
        Artisan::call('passport:keys');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('oauth_access_tokens')->truncate();
        DB::table('oauth_clients')->truncate();
        DB::table('oauth_refresh_tokens')->truncate();
    }
}
