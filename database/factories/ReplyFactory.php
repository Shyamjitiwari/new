<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    $blog = \App\Blog::all()->random();
    return [
        'parent_id' => $blog->id,
        'description' => $faker->sentence,
        'commentable_id' => $blog->id,
        'commentable_type' => 'App\Blog',
        'created_id' => \App\User::all()->random(),
        'updated_id' => \App\User::all()->random()
    ];
});
