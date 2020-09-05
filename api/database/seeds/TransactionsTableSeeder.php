<?php

use App\Models\Account;
use App\Models\Transaction;

class TransactionsTableSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = Account::all();

        $accounts->each(function ($account) {
            factory(Transaction::class)->create([
                'account_from_id' => $account->id,
                'account_to_id'   => Account::whereNotIn('id', [$account->id])->inRandomOrder()->first()->id,
                'amount'          => $this->faker->randomFloat(3, 100, 1000),
            ]);
        });
    }
}
