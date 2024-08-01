<?php

use Database\Seeders\FirstUserAccountSeeder;
use Database\Seeders\FirstUserCategorySeeder;
use Database\Seeders\FirstUserSeeder;
use Database\Seeders\FirstUserWalletSeeder;
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
        $this->call([
            FirstUserSeeder::class,
            FirstUserCategorySeeder::class,
            FirstUserAccountSeeder::class,
            FirstUserWalletSeeder::class
        ]);
    }
}
