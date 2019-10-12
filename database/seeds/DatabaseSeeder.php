<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        /*
            User
        */
        DB::table('users')->insert([
            'name' => 'Jawaid',
            'email' => 'mjawaid@gmail.com',
            'password' => bcrypt('jawaid'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        /*
            Accounts
        */
        DB::table('accounts')->insert([
            'user_id' => 1,
            'name' => 'SCB',
            'type' => 'bank',
            'currency' => 'PKR',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('accounts')->insert([
            'user_id' => 1,
            'name' => 'Cash',
            'type' => 'cash',
            'currency' => 'PKR',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('accounts')->insert([
            'user_id' => 1,
            'name' => 'EasyPaisa',
            'type' => 'mobile',
            'currency' => 'PKR',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        /*
            Tags
        */
        DB::table('tags')->insert([
            'user_id' => 1,
            'name' => 'personal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('tags')->insert([
            'user_id' => 1,
            'name' => 'work',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('tags')->insert([
            'user_id' => 1,
            'name' => 'home',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        /*
            Transactions
        */
        DB::table('transactions')->insert([
            'user_id' => 1,
            'amount' => 10000,
            'description' => 'initial load',
            'type' => 'income',
            'from_account_id' => null,
            'to_account_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('transactions')->insert([
            'user_id' => 1,
            'amount' => 1000,
            'description' => 'cash withdrawal',
            'type' => 'transfer',
            'from_account_id' => 1,
            'to_account_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('transactions')->insert([
            'user_id' => 1,
            'amount' => 100,
            'description' => 'biscuits',
            'type' => 'expense',
            'from_account_id' => 2,
            'to_account_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        /*
            Transaction Tags
        */
        DB::table('tag_transaction')->insert([
            'transaction_id' => 1,
            'tag_id' => 2
        ]);

        DB::table('tag_transaction')->insert([
            'transaction_id' => 3,
            'tag_id' => 3
        ]);
    }
}
