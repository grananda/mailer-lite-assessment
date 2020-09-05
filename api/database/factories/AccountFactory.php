<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'owner_id' => function () use ($faker) {
            return factory(User::class)->create()->id;
        },
        'account_number' => $faker->bankAccountNumber,
        'balance'        => $faker->randomFloat(3, 100, 1000),
        'currency_id'    => Currency::inRandomOrder()->first()->id,
    ];
});
