<?php

use Faker\Generator as Faker;

$factory->define(App\Policy::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigit,
        // 'branch_id' => $faker->randomDigit,
        'client_id' => $faker->numberBetween($min = 1, $max = 10),
        'InsClass_id' => $faker->randomDigit,
        'InsType_id' => $faker->randomDigit,
        'policy_no' => 'policy_'.$faker->randomNumber($nbDigits = NULL, $strict = false),
        'policy_status_id' => $faker->randomDigit,
        'insured' => $faker->name,
        'premium' => $faker->numberBetween($min = 10000, $max = 100000),
        // 'commission' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'effective_date' => $faker->date,
        'file_no' => 'file_no_'.$faker->randomNumber($nbDigits = NULL, $strict = false),
        'exp_date' => $faker->date($format = 'Y-m-d', $min = 'now'),
        'client' => $faker->name
    ];
});
