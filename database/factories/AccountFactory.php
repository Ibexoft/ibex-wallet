<?php

use Faker\Generator as Faker;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => $faker->words(3, true),
        'type' => $faker->randomElement($array = array ('cash','bank','credit card','mobile','other')),
        'currency' => $faker->currencyCode
    ];
});
