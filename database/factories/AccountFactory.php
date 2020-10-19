<?php

use Faker\Generator as Faker;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'user_id'  => 1,
        'title'    => $faker->words(3, true),
        // 'type'     => $faker->randomElement($array = ['cash', 'bank', 'credit card', 'mobile', 'other']),
        'type'     => $faker->numberBetween($min = 1, $max = 5),
        'currency' => $faker->currencyCode,
    ];
});
