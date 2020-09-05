<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create();
    }
}
