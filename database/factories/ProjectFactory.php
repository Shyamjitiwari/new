<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->word .' '. $faker->word .' '. $faker->word,
        'builder_id' => \App\Builder::all()->random(),
        'completion_status' => collect(['Under Construction','In Conceptions', 'Completed'])->random(),
        'address' => $faker->address,
        'location_id' =>  \App\Location::all()->random(),
        'city' => $faker->city,
        'state' => $faker->state,
        'pincode' => $faker->postcode,
        'possession' => $faker->dateTimeBetween('+10 days', '+30 days'),
        'distance_in_kms' => $faker->randomDigit,
        'nearby_location_id' =>  \App\Location::all()->random(),
        'status' => 'active',
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
