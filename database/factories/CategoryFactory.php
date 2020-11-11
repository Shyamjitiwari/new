<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->unique()->word;
    return [
        'name' => \Illuminate\Support\Str::upper($name),
        'slug' => \App\Helper\Helper::slugify($name,'tags'),
        'type' => collect(['blog', 'service', 'slider', 'gallery'])->random(),
        'description' => $faker->text,
        'meta_title' => Str::studly($name),
        'meta_keywords' => Str::studly($name),
        'meta_description' => $faker->text,
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random()
    ];
});
