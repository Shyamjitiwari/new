<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `settings` (`id`, `group`, `display_name`, `key`, `value`, `field_type`, `sort`, `status`, `updated_id`, `created_at`, `updated_at`) VALUES
            (1, 'private', 'App Name', 'app_name', 'tooEasy Accounting', 'text', 1, 0, NULL, '2019-12-25 22:42:20', '2019-12-25 22:42:20'),
            (2, 'private', 'Short Name', 'short_name', 'tooEasy', 'text', 1, 0, NULL, '2019-12-25 22:42:20', '2019-12-25 22:42:20'),
            (3, 'display', 'Pagination', 'pagination', '20', 'number', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-31 03:03:24'),
            (4, 'display', 'Date Format', 'date_format', 'DD-MM-YYYY', 'select', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-31 03:01:34'),
            (5, 'company', 'Time Zone', 'time_zone', 'Asia/Kolkata', 'select', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-31 05:05:36'),
            (6, 'company', 'Company Name', 'company_name', 'tooEasy', 'text', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-31 02:37:49'),
            (7, 'company', 'Landline', 'landline', '+91 9161 459 446', 'text', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-27 02:11:38'),
            (8, 'company', 'Mobile', 'mobile', '+91 7081 7081 71', 'text', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-26 03:15:17'),
            (9, 'company', 'Email', 'email', 'info@tooeasy.in', 'email', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-26 21:54:28'),
            (10, 'company', 'Address', 'address', 'Gomti Nagar Extension,\nSector - 4', 'textarea', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-26 21:54:46'),
            (11, 'company', 'City', 'city', 'Lucknow', 'text', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-25 22:42:20'),
            (12, 'company', 'Country', 'country', 'India', 'text', 1, 1, NULL, '2019-12-25 22:42:20', '2019-12-25 22:42:20');
        ");
    }
}
