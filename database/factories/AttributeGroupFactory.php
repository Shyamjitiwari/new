<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AttributeGroup;
use Faker\Generator as Faker;

$factory->define(AttributeGroup::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'description' => $faker->text,
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random()
    ];
});
