<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'name' => $faker->name,
        'company_id' => $faker->numberBetween($min = 1, $max = 10),
        'email' => $faker->safeEmail,
        'client_no' => $faker->numberBetween($min = 202209, $max = 72788181),
        'phone' => $faker->phoneNumber,
        'birth_day' => $faker->date(),
        'pin_no' => $faker->numberBetween($min = 1000, $max = 9999),
    ];
});
