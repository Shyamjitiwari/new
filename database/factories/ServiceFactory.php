<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    $name = $faker->sentence;
    return [
        'name' => $name,
        'slug' => \App\Helper\Helper::slugify($name,'services'),
        'description' => $faker->text,
        'meta_title' => $name,
        'meta_keywords' => $name,
        'meta_description' => $faker->text,
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random()
    ];
});
