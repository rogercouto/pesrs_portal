<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    return [
        'title'=> $faker->company,
        'content'=> $faker->text,
        'user_id'=> 1
    ];
});
