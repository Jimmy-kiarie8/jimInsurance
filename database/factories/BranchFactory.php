<?php

use Faker\Generator as Faker;

$factory->define(App\Branch::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'branch_id' => '1',
        'branch_name' => $faker->city,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'address' => $faker->address,
    ];
});
