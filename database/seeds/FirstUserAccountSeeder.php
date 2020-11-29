<?php

use App\User;
use App\Account;
use Illuminate\Database\Seeder;

class FirstUserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: First check if record doesn't exist already
        Account::create([
            'user_id'  => User::first()->id,
            'name'    => "Cash",
            'type'     => 1,
            'currency' => "Rs",
        ]);
    }
}
