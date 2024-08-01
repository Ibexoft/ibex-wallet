<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
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
