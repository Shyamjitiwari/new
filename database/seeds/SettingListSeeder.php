<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `setting_lists` (`id`, `setting_key`, `value`, `sort`, `status`, `updated_id`, `created_at`, `updated_at`) VALUES
            (1, 'time_zone', 'Asia/Kolkata', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00'),
            (2, 'time_zone', 'Asia/Muscat', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00'),
            (3, 'time_zone', 'Asia/Dubai', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00'),
            (4, 'time_zone', 'Asia/Dhaka', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00'),
            (5, 'time_zone', 'Asia/Kathmandu', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00'),
            (6, 'time_zone', 'Asia/Kuwait', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00'),
            (7, 'time_zone', 'Asia/Singapore', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00'),
            (8, 'date_format', 'DD-MM-YYYY', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00'),
            (9, 'date_format', 'MM-DD-YYYY', 1, 1, NULL, '2019-12-26 13:00:00', '2019-12-26 13:00:00');
        ");
    }
}
