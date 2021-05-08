<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoices;
use Faker\Generator as Faker;

$factory->define(Invoices::class, function (Faker $faker) {
    return [
        'invoice_number' => rand(100550, 8000000),
        'invoice_date' => now(),
        'dve_date' => $faker->date(),
        'product' => rand(1, 500),
        'collected_money' => rand(5800, 90000),
        'commission' => rand(500, 9000),
        'section' => rand(1, 50),
        'discount' => rand(1000, 18000),
        'rate_vat' => 5 . '%',
        'value_vat' => rand(100, 900000),
        'total' => rand(18000, 500000),
        'status' => 0,
        'note' => $faker->sentence()
    ];
});
