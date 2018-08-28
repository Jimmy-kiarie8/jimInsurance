<?php

use Faker\Generator as Faker;

$factory->define(App\Policy::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigit,
        'branch_id' => $faker->randomDigit,
        'client_id' => $faker->randomDigit,
        'InsClass_id' => $faker->randomDigit,
        'InsType_id' => $faker->randomDigit,
        'policy_no' => 'policy_'.$faker->randomNumber($nbDigits = NULL, $strict = false),
        'policy_status_id' => $faker->randomDigit,
        'insured' => $faker->name,
        'premium' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'commission' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'effective_date' => $faker->date,
        'exp_date' => $faker->date,
        'file_no' => 'file_no_'.$faker->randomNumber($nbDigits = NULL, $strict = false),
        'client' => $faker->name
    ];
});
