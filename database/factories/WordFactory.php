<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Word;
use Faker\Generator as Faker;

$factory->define(Word::class, function (Faker $faker) {
    return [
        'name' => $faker->word(1),
        'mean' => $faker->sentence(3),
        // course_id
    ];
});
