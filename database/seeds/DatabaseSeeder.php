<?php

use App\AttributeGroup;
use App\Service;
use App\User;
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
        $this->call(SettingListSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ReplySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(AttributeGroupSeeder::class);
        $this->call(AttributesSeeder::class);

        DB::insert("INSERT INTO `imagables` (`id`, `image_id`, `imagable_id`, `imagable_type`, `alt`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `primary`, `created_at`, `updated_at`) VALUES
            (1, 1, 3, 'App\Blog', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
            (2, 2, 4, 'App\Blog', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
            (3, 3, 5, 'App\Blog', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
            (4, 4, 6, 'App\Blog', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
            (5, 5, 7, 'App\Blog', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL);
        ");

        DB::insert("INSERT INTO `images` (`id`, `name`, `thumbnail`, `folder`, `status`, `updated_id`, `created_id`, `created_at`, `updated_at`) VALUES
            (1, '1592829397.png', '1592829397_thumb.png', 'blogs', 'active', NULL, NULL, '2020-06-22 12:36:37', '2020-06-22 12:36:37'),
            (2, '1592829863.png', '1592829863_thumb.png', 'blogs', 'active', NULL, NULL, '2020-06-22 12:44:23', '2020-06-22 12:44:23'),
            (3, '1592829921.png', '1592829921_thumb.png', 'blogs', 'active', NULL, NULL, '2020-06-22 12:45:21', '2020-06-22 12:45:21'),
            (4, '1592829958.png', '1592829958_thumb.png', 'blogs', 'active', NULL, NULL, '2020-06-22 12:45:58', '2020-06-22 12:45:58'),
            (5, '1592829989.png', '1592829989_thumb.png', 'blogs', 'active', NULL, NULL, '2020-06-22 12:46:29', '2020-06-22 12:46:29');
        ");
    }
}
