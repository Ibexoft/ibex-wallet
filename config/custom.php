<?php

return [
    'account_types' => [
        1 => [
            'name' => 'Cash',
            'icon' => 'fa-solid fa-coins',
        ],
        2 => [
            'name' => 'Credit Card',
            'icon' => 'fa-solid fa-credit-card',
        ],
        3 => [
            'name' => 'Bank',
            'icon' => 'fa-solid fa-landmark',
        ],
        4 => [
            'name' => 'Mobile Payment',
            'icon' => 'fa-solid fa-mobile-screen-button',
        ],
        // Add more types here as needed
    ],
    'currencies' => [
        'PKR' => 'PKR',
        'USD' => 'USD',
        // Add more currencies as needed
    ],
    'transaction_types' => [
        'income' => 2,
        'expense' => 1,
        'transfer' => 3,
    ],
];
