<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'parent_id' => null,
        'description' => $faker->sentence,
        'commentable_id' => \App\Blog::all()->random(),
        'commentable_type' => 'App\Blog',
        'created_id' => null,
        'updated_id' => null
    ];
});
