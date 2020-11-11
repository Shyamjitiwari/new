<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;
use Psy\Util\Str;

$factory->define(Blog::class, function (Faker $faker) {
    $name = $faker->sentence;
    return [
        'name' => $name,
        'slug' => \App\Helper\Helper::slugify($name,'blogs'),
        'category_id' => \App\Category::where('type', 'blog')->orWhere('type', null)->get()->random(),
        'description' => $faker->text,
        'read_time' => collect([2,3,4,5,6])->random(),
        'meta_title' => $name,
        'meta_keywords' => $name,
        'meta_description' => $faker->text,
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random()
    ];
});
