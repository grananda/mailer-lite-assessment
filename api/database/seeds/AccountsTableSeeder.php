<?php

use App\Models\Account;

class AccountsTableSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = $this->getSeedFileContents('accounts');

        foreach ($accounts as $account) {
            factory(Account::class)->create([
                'account_number' => $account['account_number'],
            ]);
        }
    }
}
