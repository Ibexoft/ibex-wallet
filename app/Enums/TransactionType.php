<?php
namespace App\Enums;

enum TransactionType: int
{
    case Expense = 1;
    case Income = 2;
    case Transfer = 3;

    public function label(): string
    {
        return match($this) {
            TransactionType::Expense => 'Expense',
            TransactionType::Income => 'Income',
            TransactionType::Transfer => 'Transfer',
        };
    }
}
