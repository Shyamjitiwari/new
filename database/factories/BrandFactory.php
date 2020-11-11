<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    $name = $faker->unique()->word;
    return [
        'name' => $name,
        'slug' => \App\Helper\Helper::slugify($name,'brands'),
        'description' => $faker->text,
        'meta_title' => $name,
        'meta_keywords' => $name,
        'meta_description' => $faker->text,
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random()
    ];
});
