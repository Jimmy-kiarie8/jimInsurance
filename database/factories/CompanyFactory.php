<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'branch_name' => $faker->city,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'address' => $faker->address,
        'logo' => $faker->imageUrl($width = 640, $height = 480),
    ];
});
