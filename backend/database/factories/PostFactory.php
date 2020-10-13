<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 20),
        'skill_id' => $faker->numberBetween(1, 31),
        'time' => $faker->numberBetween(30, 720),
        'comment' => $faker->realText(50),
        'created_at' => $faker->dateTimeBetween('-30days', 'now')->format('Y-m-d H:i:s'),
    ];
});
