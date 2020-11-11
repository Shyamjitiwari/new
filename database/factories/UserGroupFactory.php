<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserGroup;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(UserGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' =>collect(['active','inactive'])->random(),
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
