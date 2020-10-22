<?php

use App\Category;
use App\User;
use Illuminate\Database\Seeder;

class FirstUserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::bulkCreateForUser(
            User::first()->id,
            config('defaultcategories')
        );
    }
}
