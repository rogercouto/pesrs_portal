<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Message::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'subject' => $faker->company,
        'content' => $faker->text,
        'readed' => $faker->boolean,
        'answered' => $faker->dateTime
    ];
});
