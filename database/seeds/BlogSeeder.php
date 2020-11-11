<?php

use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = App\Tag::all()->pluck('id');
        factory(\App\Blog::class, 150)
            ->create()
            ->each(function ($blog) use($tags) {
            $blog->tags()->attach($tags->random());
            $blog->tags()->attach($tags->random());
        });
    }
}
