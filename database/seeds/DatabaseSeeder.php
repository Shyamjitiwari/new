<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(PermissionSeeder::class);

        $u = new \App\User;
        $u->name = 'tel';
        $u->email = 'tele2@gmail.com';
        $u->password = bcrypt('12345678');
        $u->role_id = 3;
        $u->save();

        $u = new \App\User;
        $u->name = 'adm';
        $u->email = 'admin2@gmail.com';
        $u->password = bcrypt('12345678');
        $u->role_id = 2;
        $u->save();

        $u = new \App\User;
        $u->name = 'tel';
        $u->email = 'tele3@gmail.com';
        $u->password = bcrypt('12345678');
        $u->role_id = 3;
        $u->save();

        $this->call(SettingListSeeder::class);
        $this->call(SettingSeeder::class);

        DB::insert("INSERT INTO `lead_sources` (`id`, `name`, `status`, `created_id`, `updated_id`, `created_at`, `updated_at`) VALUES
            (1, 'Magicbricks', 'active', 2, NULL, '2020-02-23 17:45:21', '2020-02-23 17:45:21'),
            (2, '99Acres', 'active', 2, NULL, '2020-02-23 17:45:31', '2020-02-23 17:45:31'),
            (3, 'Housing', 'active', 2, NULL, '2020-02-23 17:46:01', '2020-02-23 17:46:01'),
            (4, 'Commonfloor', 'active', 2, NULL, '2020-02-23 17:46:06', '2020-02-23 17:46:06'),
            (5, 'Google', 'active', 2, NULL, '2020-02-23 17:46:12', '2020-02-23 17:46:12'),
            (6, 'Facebook', 'active', 2, NULL, '2020-02-23 17:46:23', '2020-02-23 17:46:23'),
            (7, 'Inorganic', 'active', 2, NULL, '2020-02-23 17:46:23', '2020-02-23 17:46:23'),
            (8, 'Roof&Floor', 'active', 2, NULL, '2020-02-23 17:46:23', '2020-02-23 17:46:23'),
            (9, 'Reference', 'active', 2, NULL, '2020-02-23 17:46:23', '2020-02-23 17:46:23');
        ");

        DB::insert("INSERT INTO `lead_statuses` (`id`, `name`, `parent_id`, `bg`, `text`, `status`, `created_id`, `updated_id`, `created_at`, `updated_at`) VALUES
            (1, 'Unattanded', NULL, 'yellow', 'black', 'active', 2, NULL, '2020-03-03 01:30:54', '2020-03-03 01:30:54'),
            (2, 'Dead', NULL, 'red', 'white', 'active', 2, NULL, '2020-03-03 01:31:07', '2020-03-03 01:31:07'),
            (3, 'Assorted', NULL, 'purple', 'white', 'active', 2, NULL, '2020-03-03 01:31:18', '2020-03-03 01:31:18'),
            (4, 'In Progress', NULL, 'green', 'white', 'active', 2, NULL, '2020-03-03 01:31:28', '2020-03-03 01:31:28'),
            (5, 'Prospect', NULL, 'lightgreen', 'black', 'active', 2, NULL, '2020-03-03 01:31:48', '2020-03-03 01:31:48'),
            (6, 'Site visit', NULL, 'red', 'black', 'active', 2, NULL, '2020-03-03 01:31:58', '2020-03-03 01:31:58'),
            (7, 'Re visit', NULL, 'maroon', 'white', 'active', 2, NULL, '2020-03-03 01:32:11', '2020-03-03 01:32:11'),
            (8, 'Negotiation', NULL, 'blue', 'white', 'active', 2, NULL, '2020-03-03 01:32:25', '2020-03-03 01:32:25'),
            (9, 'Order Closed', NULL, 'black', 'white', 'active', 2, NULL, '2020-03-03 01:32:40', '2020-03-03 01:32:40'),
            (10, 'Invoicing', NULL, 'magenta', 'white', 'active', 2, NULL, '2020-03-03 01:32:54', '2020-03-03 01:32:54'),
            (12, 'Un Attented', 1, 'yellow', 'black', 'active', 2, NULL, '2020-03-03 01:33:53', '2020-03-03 01:33:53'),
            (13, 'Not interested', 2, 'red', 'white', 'active', 2, NULL, '2020-03-03 01:34:13', '2020-03-03 01:34:13'),
            (14, 'Not Reachable', 2, 'red', 'white', 'active', 2, NULL, '2020-03-03 01:34:22', '2020-03-03 01:34:22'),
            (15, 'invalid number', 2, 'red', 'white', 'active', 2, NULL, '2020-03-03 01:34:33', '2020-03-03 01:34:33'),
            (16, 'Service Provider', 2, 'red', 'white', 'active', 2, NULL, '2020-03-03 01:34:47', '2020-03-03 01:34:47'),
            (17, 'Under Budget', 3, 'purple', 'white', 'active', 2, NULL, '2020-03-03 01:35:10', '2020-03-03 01:35:10'),
            (18, 'Location Mismatch', 3, 'purple', 'white', 'active', 2, NULL, '2020-03-03 01:35:27', '2020-03-03 01:35:27'),
            (19, 'Requirement Mismatch', 3, 'purple', 'white', 'active', 2, NULL, '2020-03-03 01:35:37', '2020-03-03 01:35:37'),
            (20, 'For Resale', 3, 'purple', 'white', 'active', 2, NULL, '2020-03-03 01:35:50', '2020-03-03 01:35:50'),
            (21, 'Call Back', 4, 'green', 'white', 'active', 2, NULL, '2020-03-03 01:36:06', '2020-03-03 01:36:06'),
            (22, 'RNR', 4, 'green', 'white', 'active', 2, NULL, '2020-03-03 01:36:06', '2020-03-03 01:36:06'),
            (24, 'Interested', 5, 'lightgreen', 'black', 'active', 2, NULL, '2020-03-03 01:37:46', '2020-03-03 01:37:46'),
            (25, 'Site Visit Confirmed', 6, 'red', 'black', 'active', 2, NULL, '2020-03-03 01:38:11', '2020-03-03 01:38:11'),
            (26, 'Site Visit Fixed', 6, 'red', 'black', 'active', 2, NULL, '2020-03-03 01:38:11', '2020-03-03 01:38:11'),
            (27, 'Site Visit Done', 6, 'red', 'black', 'active', 2, NULL, '2020-03-03 01:38:11', '2020-03-03 01:38:11'),
            (28, 'Revisit with Family', 7, 'maroon', 'white', 'active', 2, NULL, '2020-03-03 01:39:22', '2020-03-03 01:39:22'),
            (29, 'Revisit for different Project', 7, 'maroon', 'white', 'active', 2, NULL, '2020-03-03 01:39:48', '2020-03-03 01:39:48'),
            (30, 'Revisit For Negotiation', 8, 'blue', 'white', 'active', 2, NULL, '2020-03-03 01:40:35', '2020-03-03 01:40:35'),
            (31, 'Revisit for Negotiation and closer', 8, 'blue', 'white', 'active', 2, NULL, '2020-03-03 01:40:41', '2020-03-03 01:40:41'),
            (32, 'OrderClosed', 9, 'black', 'white', 'active', 2, NULL, '2020-03-03 01:41:29', '2020-03-03 01:41:29'),
            (33, 'Booking', 9, 'black', 'white', 'active', 2, NULL, '2020-03-03 01:41:34', '2020-03-03 01:41:34'),
            (34, 'RNR Post site visit', 9, 'black', 'white', 'active', 2, NULL, '2020-03-03 01:41:37', '2020-03-03 01:41:37'),
            (35, 'Agreement Done', 10, 'magenta', 'white', 'active', 2, NULL, '2020-03-03 01:42:42', '2020-03-03 01:42:42'),
            (36, 'Registeration Done', 10, 'magenta', 'white', 'active', 2, NULL, '2020-03-03 01:42:43', '2020-03-03 01:42:43');
        ");
             factory(\App\Builder::class,25)->create();
             factory(\App\Location::class,25)->create();
            factory(\App\Project::class,25)->create();
            factory(\App\ProjectUnit::class,25)->create();
            factory(\App\Lead::class,500)->create();
            factory(\App\UserGroup::class,10)->create();

    }
}
