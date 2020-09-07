<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'avatar' => 'avatar.png',
        'gender' => $faker->randomElement([true, false]),
        // user_id
    ];
});
