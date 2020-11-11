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
        DB::insert("INSERT INTO `settings` (`id`, `group`, `display_name`, `key`, `value`, `icon`, `field_type`, `sort`, `status`, `updated_id`, `created_at`, `updated_at`) VALUES
            (1, 'private', 'App Name', 'app_name', 'tooEasy Blog', 'fas fa-cog text-primary', 'text', 1, 0, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (2, 'private', 'Short Name', 'short_name', 'tooEasy', 'fas fa-cog text-primary', 'text', 1, 0, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (3, 'display', 'Pagination', 'pagination', '20', 'fas fa-cog text-primary', 'number', 1, 1, NULL, '2019-12-25 11:42:20', '2020-07-30 09:39:00'),
            (4, 'display', 'Date Format', 'date_format', 'DD-MM-YYYY', 'fas fa-cog text-primary', 'select', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-30 16:01:34'),
            (5, 'company', 'Time Zone', 'time_zone', 'Asia/Kolkata', 'fas fa-cog text-primary', 'select', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-30 18:05:36'),
            (6, 'company', 'Company Name', 'company_name', 'tooEasy', 'fas fa-cog text-primary', 'text', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-30 15:37:49'),
            (7, 'company', 'Landline', 'landline', '+91 9161 459 446', 'fas fa-cog text-primary', 'text', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-26 15:11:38'),
            (8, 'company', 'Mobile', 'mobile', '+91 7081 7081 71', 'fas fa-cog text-primary', 'text', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 16:15:17'),
            (9, 'company', 'Email', 'email', 'info@tooeasy.in', 'fas fa-cog text-primary', 'email', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-26 10:54:28'),
            (10, 'company', 'Address', 'address', 'Gomti Nagar Extension,\nSector - 4', 'fas fa-cog text-primary', 'textarea', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-26 10:54:46'),
            (11, 'company', 'City', 'city', 'Lucknow', 'fas fa-cog text-primary', 'text', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (12, 'company', 'Country', 'country', 'India', 'fas fa-cog text-primary', 'text', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (13, 'SMTP Settings', 'Host', 'host', 'smtp.mailtrap.io', 'fas fa-cog text-primary', 'text', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (14, 'SMTP Settings', 'Port', 'port', '2525', 'fas fa-cog text-primary', 'number', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (15, 'SMTP Settings', 'Username', 'username', '9bc023f69a2827', 'fas fa-cog text-primary', 'text', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (16, 'SMTP Settings', 'Password', 'password', '9bc023f69a2827', 'fas fa-cog text-primary', 'password', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (17, 'SMTP Settings', 'Encryption', 'encryption', 'tls', 'fas fa-cog text-primary', 'text', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (18, 'Javascript', 'Google Analytics', 'google-analytics', '<script></script>', 'fas fa-cog text-primary', 'textarea', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (19, 'Social Links', 'Facebook', 'facebook', 'https://www.facebook.com/', 'fab fa-facebook text-primary', 'url', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (20, 'Social Links', 'Twitter', 'twitter', 'https://www.twitter.com/', 'fab fa-twitter-square text-primary', 'url', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (21, 'Social Links', 'LinkedIn', 'linkedin', 'https://www.linkedin.com/', 'fab fa-linkedin text-primary', 'url', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20'),
            (22, 'Social Links', 'Instagram', 'instagram', 'https://www.instagram.com/', 'fab fa-instagram text-primary', 'url', 1, 1, NULL, '2019-12-25 11:42:20', '2019-12-25 11:42:20');
            ");
        }
}
