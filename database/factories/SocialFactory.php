<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Social;
use Faker\Generator as Faker;

$factory->define(Social::class, function (Faker $faker) {
    return [
        'provider_id' => $faker->randomNumber(5),
        'provider_name' => $faker->word(1),
        'access_token' => null,
        // user_id
    ];
});
