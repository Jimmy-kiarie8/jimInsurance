<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'verifyToken' => Str::random(40),
        'branch_id' => $faker->randomDigit,
        'user_id' => '1',
        'email' => $faker->unique()->safeEmail,
        'verifyToken' => Str::random(40),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'phone' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'address' => $faker->address,
        'profile' => $faker->imageUrl($width = 640, $height = 480),
        'status' => $faker->boolean,
        'verifyToken' => $faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'),
        'remember_token' => str_random(10),
    ];
});
