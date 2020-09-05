<?php

use App\Models\Account;
use App\Models\User;

class AccountsTableSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $users->each(function ($user) {
            factory(Account::class)->create(
                [
                    'owner_id' => $user->id,
                ]
            );
        });
    }
}
