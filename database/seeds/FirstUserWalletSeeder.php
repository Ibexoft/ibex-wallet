<?php

use App\User;
use App\Wallet;
use Illuminate\Database\Seeder;

class FirstUserWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: First check if record doesn't exist already
        Wallet::create([
            'user_id'  => User::first()->id,
            'name'    => "Default"
        ]);
    }
}
