<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'name' => $faker->word .' '. $faker->word,
        'address' => $faker->address,
        'pincode' => $faker->postcode,
        'level' => 0,
        'status' =>collect(['active','inactive'])->random(),
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
