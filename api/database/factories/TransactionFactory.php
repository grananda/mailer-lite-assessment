<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'account_from_id' => null,
        'account_to_id'   => null,
        'details'         => $faker->text,
        'amount'          => $faker->randomFloat(2, 1, 100),
        'status'          => true,
    ];
});
