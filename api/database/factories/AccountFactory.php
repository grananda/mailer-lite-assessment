<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use App\Models\Currency;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'owner_id'       => null,
        'account_number' => $faker->bankAccountNumber,
        'balance'        => $faker->randomFloat(3, 100, 1000),
        'currency_id'    => Currency::inRandomOrder()->first()->id,
    ];
});
