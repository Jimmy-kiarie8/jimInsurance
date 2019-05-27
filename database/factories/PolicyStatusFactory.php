<?php

use Faker\Generator as Faker;

$factory->define(App\PolicyStatus::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'code' => $faker->ean8,
        'description' => $faker->realText(),
    ];
});
