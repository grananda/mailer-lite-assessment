<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CurrenciesTableSeeder::class);

        if (! app()->environment('testing')) {
            $this->call(AccountsTableSeeder::class);
            $this->call(TransactionsTableSeeder::class);
        }
    }
}
