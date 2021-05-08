<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sections;
use Faker\Generator as Faker;

$factory->define(Sections::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'user' => 1
    ];
});
