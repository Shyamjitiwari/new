<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Testimonial;
use Faker\Generator as Faker;

$factory->define(Testimonial::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'company' => $faker->company,
        'designation' => $faker->jobTitle,
        'description' => $faker->text,
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random()
    ];
});
