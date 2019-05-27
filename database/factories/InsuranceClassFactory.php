<?php

use Faker\Generator as Faker;

$factory->define(App\InsuranceClass::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'code' => $faker->ean8,
        'description' => $faker->realText(),
        'commission_rate' => $faker->numberBetween($min = 3, $max = 30),
        'coverage' => $faker->numberBetween($min = 300, $max = 30000),
    ];
});
