<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Option;
use Faker\Generator as Faker;

$factory->define(Option::class, function (Faker $faker) {
    return [
        'name' => $faker->word(3),
        'is_correct' => $faker->randomElement([true, false]),
        // question_id
    ];
});
