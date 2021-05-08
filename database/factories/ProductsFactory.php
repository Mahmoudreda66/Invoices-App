<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'product_name' => $faker->sentence(),
        'description' => $faker->paragraph(),
        'section_id' => rand(1, 50)
    ];
});
