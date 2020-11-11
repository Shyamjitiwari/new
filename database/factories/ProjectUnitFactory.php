<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\ProjectUnit;
use Faker\Generator as Faker;

$factory->define(ProjectUnit::class, function (Faker $faker) {
    return [
        'type' => $faker->randomDigit .'BHK',
        'price' => $faker->numberBetween($min = 1000000, $max = 9000000),
        'size' => $faker->numberBetween($min = 1000, $max = 9000),
        'project_id' =>  \App\Project::all()->random(),
        'sales_type' => $faker->word,
        'bedroom' => $faker->randomDigit,
        'bathroom' => $faker->randomDigit,
        'balcony' => $faker->randomDigit,
        'additional_room' => collect(0.5,1,1.5,2)->random(),
        'status' => collect('active','inactive')->random() ,
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
