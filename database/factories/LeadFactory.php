<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lead;
use Faker\Generator as Faker;

$factory->define(Lead::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'mobile' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'remarks' => $faker->paragraph. ' ' .$faker->paragraph,
        'lead_status_id' => \App\LeadStatus::where('parent_id', '!=', null)->get()->random(),
        'lead_source_id' => \App\LeadSource::all()->random(),
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random(),
        'created_at' => \Carbon\Carbon::now()->subDays(10),
        'updated_at' => \Carbon\Carbon::now()->subDays(10),
    ];
});
