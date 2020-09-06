<?php

use App\Models\Currency;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var Factory $factory */
$factory->define(Currency::class, function (Faker $faker) {
    return [
        'symbol'        => $faker->word,
        'name'          => $faker->word,
        'symbol_native' => $faker->word,
        'code'          => $faker->currencyCode,
        'name_plural'   => $faker->words(2, true),
        'exchange_rate' => 1,
        'is_default'    => false,
    ];
});
